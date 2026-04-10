<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;


class PembeliController extends Controller
{
    #intinya nampilin produk di dashboard pembeli
    public function index(Request $request)
    {
        $categories = Category::all();

        // 1. AMBIL PRODUK UNGGULAN (FEATURED) UNTUK SLIDER
        // Ambil maksimal 5 produk featured yang aktif
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(5)
            ->get();

        // 2. Query Produk Biasa (Katalog Bawah)
        $query = Product::where('is_active', true);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->paginate(12);

        // Jangan lupa kirim 'featuredProducts' ke view
        return view('pembeli.dashboard', compact('products', 'categories', 'featuredProducts'));
    }
    /**
     * Menampilkan Detail Produk
     */

    #buat nampilin detail pproduk
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();


        return view('pembeli.detail', compact('product', 'relatedProducts'));
    }
}