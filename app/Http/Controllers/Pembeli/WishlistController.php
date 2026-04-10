<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    


    public function index()
    {
        // Ambil data wishlist milik user yang login, beserta data produknya
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product') // Eager Loading biar query ringan
            ->latest()
            ->get();

        return view('pembeli.wishlist', compact('wishlists'));
    }


    // intinya buat nambahin,onDelete wishlist ama buat tanda hati merah awww awawokawoawkoawkaowk
    public function toggle(Product $product)
    {
        $user_id = Auth::id();

        // Cek apakah sudah ada di wishlist?
        $wishlist = Wishlist::where('user_id', $user_id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            // Kalau sudah ada -> HAPUS (Unlike)
            $wishlist->delete();
            return back()->with('success', 'Produk dihapus dari Wishlist.');
        } else {
            // Kalau belum ada -> BUAT (Like)
            Wishlist::create([
                'user_id' => $user_id,
                'product_id' => $product->id
            ]);
            return back()->with('success', 'Produk ditambahkan ke Wishlist!');
        }
    }
}