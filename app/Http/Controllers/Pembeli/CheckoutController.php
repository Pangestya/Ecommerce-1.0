<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Alamat;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Pastikan Model Product di-import
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // 1. Menampilkan Halaman Checkout
    public function index()
    {
        $userId = Auth::id();
        
        // Ambil Keranjang
        $carts = Cart::where('user_id', $userId)->with('product')->get();
        
        if($carts->isEmpty()) {
            return redirect()->route('pembeli.cart.index');
        }

        // Ambil Alamat Utama
        $alamat = Alamat::where('user_id', $userId)->where('is_primary', true)->first();

        // Jika tidak ada alamat utama, ambil yang terakhir dibuat (Fallback)
        if(!$alamat) {
            $alamat = Alamat::where('user_id', $userId)->latest()->first();
        }

        if(!$alamat) {
            return redirect()->route('pembeli.profile.edit')
                ->with('error', 'Mohon isi alamat pengiriman dan data diri terlebih dahulu sebelum melakukan checkout.');
        }

        // Hitung Total Berat & Subtotal
        $totalBerat = 0;
        $subtotal = 0;

        foreach($carts as $cart) {
            $beratProduk = $cart->product->weight ?? 1000; 
            $totalBerat += ($beratProduk * $cart->quantity);
            $subtotal += ($cart->product->price * $cart->quantity);
        }

        // List Kurir
        $couriers = [
            'jne' => 'JNE',
            'pos' => 'POS Indonesia',
            'jnt' => 'JNT',
        ];

        return view('pembeli.checkout', compact('carts', 'alamat', 'totalBerat', 'subtotal','couriers'));
    }

    // 2. API Internal Check Ongkir (AJAX)
    public function checkOngkir(Request $request)
    {
        // Validasi Input AJAX
        $request->validate([
            'destination' => 'required', // ID Kelurahan/Kecamatan Tujuan
            'weight' => 'required|numeric',
            'courier' => 'required|string'
        ]);

        // ================= KONFIGURASI KOMERCE V2 =================
        $url = 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost';
        $origin = 63127; // Desa Mojoreno
        $apiKey = env('RAJAONGKIR_API_KEY'); 

        try {
            $response = Http::withHeaders([
                'key' => $apiKey,
            ])->asForm()->post($url, [
                'origin'      => $origin,
                'destination' => $request->destination,
                'weight'      => $request->weight,
                'courier'     => $request->courier
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'API Error',
                    'message' => $response->json()['meta']['message'] ?? 'Gagal mengambil data ongkir',
                    'raw' => $response->json()
                ], 500);
            }
            
            $data = $response->json();

            return response()->json([
                'rajaongkir' => [
                    'results' => [
                        [
                            'code' => $request->courier,
                            'costs' => $data['data'] ?? [] 
                        ]
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 3. Proses Checkout (Simpan ke Database & Request Midtrans)
    public function process(Request $request)
    {
        // 1. Validasi Data yang dikirim Form
        $request->validate([
            'destination_id' => 'required', 
            'courier' => 'required|string', 
            'shipping_service' => 'required|string', 
            'ongkir' => 'required|numeric', 
            'grand_total' => 'required|numeric', 
        ]);

        // 2. Mulai Transaksi Database
        DB::beginTransaction();

        try {
            $user = Auth::user();
            
            // Ambil Keranjang
            $carts = Cart::where('user_id', $user->id)->with('product')->get();

            if($carts->isEmpty()) {
                // Jika keranjang kosong, kirim respon error JSON agar JS tahu
                return response()->json(['status' => 'error', 'message' => 'Keranjang belanja kosong.'], 400);
            }

            $realSubtotal = 0;
            $realWeight = 0;

            // --- A. CEK STOK & KURANGI STOK (LOCKING) ---
            foreach($carts as $c) {
                // Lock produk untuk mencegah race condition (rebutan stok)
                $product = Product::lockForUpdate()->find($c->product_id);
                
                // Cek Stok
                if($product->stock < $c->quantity) {
                    throw new \Exception("Stok produk " . $product->name . " tidak mencukupi.");
                }

                $realSubtotal += $product->price * $c->quantity;
                $realWeight += ($product->weight ?? 1000) * $c->quantity;

                // KURANGI STOK DISINI
                $product->decrement('stock', $c->quantity);
            }

            // Generate Nomor Invoice & Midtrans ID
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());
            $midtransBookingCode = 'TRX-' . time() . '-' . $user->id;

            // 3. Simpan ke Tabel Orders
            // Note: Nama kolom disesuaikan dengan file migration `create_orders_table` Anda
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'midtrans_booking_code' => $midtransBookingCode,
                'status' => 'pending', 
                
                // Info Penerima (Mapping: Controller -> Database)
                'name' => $user->name,               // DB: name
                'phone' => $user->phone ?? '-',      // DB: phone
                'address_detail' => $request->input('detail_alamat_lengkap') ?? 'Alamat Tersimpan', // DB: address_detail
                
                // Data Lokasi Dummy (Karena DB membutuhkan kolom ini)
                'subdistrict' => '-', 'city' => '-', 'province' => '-', 'postal_code' => '-',

                // Info Pengiriman
                'courier' => $request->courier,
                'shipping_service' => $request->shipping_service, // DB: shipping_service
                'shipping_cost' => $request->ongkir,              // DB: shipping_cost
                'total_weight' => $realWeight,                    // DB: total_weight
                'etd' => $request->etd,

                // Info Biaya
                'subtotal' => $realSubtotal,
                'grand_total' => $realSubtotal + $request->ongkir,
                'notes' => $request->notes ?? null,
            ]);

            // 4. Pindahkan Item Keranjang ke OrderItems
            foreach($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name, // Snapshot Nama
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price, 
                    'subtotal' => $cart->product->price * $cart->quantity,
                ]);
            }

            // 5. Konfigurasi Midtrans & Request Snap Token
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $midtransBookingCode, // ID Unik Midtrans
                    'gross_amount' => (int) $order->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'callbacks' => [
                    'finish' => route('pembeli.riwayat.index'), // Redirect sukses
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'unit' => 'minutes', 
                    'duration' => 60 // Order expire dalam 60 menit
                ],
            ];

            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan token ke database
            $order->update(['snap_token' => $snapToken]);

            // 6. Hapus Keranjang User
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // 7. Return JSON response untuk Javascript
            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'redirect_url' => route('pembeli.riwayat.index') // Pastikan route ini ada
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error', 
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}