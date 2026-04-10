<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product; // Import Model Product
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Transaction;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // --- 1. SETTING MIDTRANS ---
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // --- 2. CEK STATUS ORDER YANG MASIH 'PENDING' ---
        // Kita hanya cek yang pending saja biar loading tidak berat
        $pendingOrders = Order::where('user_id', $userId)
                              ->where('status', 'pending')
                              ->whereNotNull('midtrans_booking_code')
                              ->get();

        foreach($pendingOrders as $order) {
            try {
                // Tanya ke Midtrans: "Status order ini apa sekarang?"
                $status = Transaction::status($order->midtrans_booking_code);

                // Jika di Midtrans sudah LUNAS (Settlement/Capture)
                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $order->update(['status' => 'paid']);
                }
                // Jika di Midtrans sudah GAGAL/EXPIRE/CANCEL
                else if (in_array($status->transaction_status, ['expire', 'cancel', 'deny'])) {
                    
                    // Balikin Stok Dulu (Penting!)
                    $this->restoreStock($order);
                    
                    // Ubah status jadi cancelled
                    $order->update(['status' => 'cancelled']);
                }

            } catch (\Exception $e) {
                // Jika error (misal koneksi putus atau not found), biarkan saja pending
                continue; 
            }
        }

        // --- 3. AMBIL DATA TERBARU (SETELAH DI-UPDATE) ---
        $orders = Order::where('user_id', $userId)
                        ->with('items.product') 
                        ->latest()
                        ->get();

        return view('pembeli.riwayat.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->with('items.product')->where('id', $id)->firstOrFail();
        return view('pembeli.riwayat.show', compact('order'));
    }

    // Fungsi Pembantu: Mengembalikan Stok
    private function restoreStock($order) {
        // Gunakan Transaksi DB agar aman
        DB::transaction(function () use ($order) {
            // Loop setiap item di order tersebut
            foreach ($order->items as $item) {
                // Kembalikan stok ke produk aslinya
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        });
    }

    public function complete(Request $request, $id)
    {
        // Pastikan order milik user yang login
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Hanya bisa selesaikan jika statusnya 'shipped' (dikirim)
        if ($order->status == 'shipped') {
            $order->update(['status' => 'completed']);
            return back()->with('success', 'Terima kasih! Transaksi telah selesai.');
        }

        return back()->with('error', 'Pesanan belum dikirim atau sudah selesai.');
    }
}