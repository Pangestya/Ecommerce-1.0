<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    #ini buat nampilin halaman beserta produknya yah
    public function index()
    {
        // Ambil data keranjang milik user yang sedang login
        $carts = Cart::where('user_id', Auth::id())
                     ->with('product') // Ambil data produknya sekalian biar ringan
                     ->latest()
                     ->get();

        return view('pembeli.cart', compact('carts'));
    }


    #intinya nambahin barang ke kerajang
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $qty = $request->quantity;

        // Cek Stok Produk Dulu
        $product = Product::find($productId);
        if ($product->stock < $qty) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Cek apakah barang ini SUDAH ADA di keranjang user?
        $existingCart = Cart::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($existingCart) {
            // Jika sudah ada, tambahkan jumlahnya (Update)
            // Cek lagi supaya totalnya gak melebihi stok
            if (($existingCart->quantity + $qty) > $product->stock) {
                return back()->with('error', 'Stok tidak cukup untuk menambah jumlah.');
            }
            
            $existingCart->quantity += $qty;
            $existingCart->save();
        } else {
            // Jika belum ada, buat baris baru (Create)
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $qty
            ]);
        }

        return redirect()->route('pembeli.cart.index')->with('success', 'Produk berhasil masuk keranjang!');
    }

    #ini ngehapus ya
    public function destroy($id)
    {
        // Cari keranjang berdasarkan ID dan pastikan milik user yang login
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $cart->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    #ini ngeupdate
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Cari data keranjang milik user ini
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Cek stok produk tersedia gak?
        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Stok tidak mencukupi. Maksimal: ' . $cart->product->stock);
        }

        // Update jumlah
        $cart->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }
}