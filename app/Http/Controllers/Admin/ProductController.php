<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'weight'         => 'required|integer|min:1',
            'length'         => 'nullable|integer|min:1',
            'width'          => 'nullable|integer|min:1',
            'height'         => 'nullable|integer|min:1',
            'image'          => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('image')) {
            $coverPath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'user_id'     => Auth::id(),
            'updated_by'  => Auth::id(),
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'weight'      => $request->weight,
            'length'      => $request->length,
            'width'       => $request->width,
            'height'      => $request->height,
            'image'       => $coverPath,
            'is_active'   => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ]);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('product_gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        $formattedPrice = number_format($product->price);
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'model_type' => 'Produk',
            'model_name' => $product->name,
            'details'    => "Menambahkan produk baru. Stok Awal: {$product->stock}, Harga: Rp {$formattedPrice}, Berat: {$product->weight}g",
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'weight'         => 'required|integer|min:1',
            'length'         => 'nullable|integer|min:1',
            'width'          => 'nullable|integer|min:1',
            'height'         => 'nullable|integer|min:1',
            'image'          => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ]);

        $product->category_id = $request->category_id;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->stock       = $request->stock;
        $product->weight      = $request->weight;
        $product->length      = $request->length;
        $product->width       = $request->width;
        $product->height      = $request->height;
        $product->is_active   = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');
        $product->updated_by  = Auth::id();

        $changes = [];
        if ($product->isDirty()) {
            foreach ($product->getDirty() as $field => $newValue) {
                if ($field === 'updated_by' || $field === 'updated_at') continue;

                $oldValue = $product->getOriginal($field);
                $fieldNameIndo = $this->translateField($field);

                if ($field === 'is_active' || $field === 'is_featured') {
                    $oldStatus = $oldValue ? 'Ya' : 'Tidak';
                    $newStatus = $newValue ? 'Ya' : 'Tidak';
                    $changes[] = "$fieldNameIndo: $oldStatus -> $newStatus";
                } elseif ($field === 'category_id') {
                    $oldCat = Category::find($oldValue)->name ?? '-';
                    $newCat = Category::find($newValue)->name ?? '-';
                    $changes[] = "Kategori: '$oldCat' -> '$newCat'";
                } else {
                    $changes[] = "$fieldNameIndo: '$oldValue' -> '$newValue'";
                }
            }
        }

        if ($request->hasFile('image')) {
            if ($product->getOriginal('image')) {
                Storage::disk('public')->delete($product->getOriginal('image'));
            }
            $product->image = $request->file('image')->store('products', 'public');
            $changes[] = "Ganti Cover Utama";
        }

        $product->save();

        if ($request->hasFile('gallery_images')) {
            $count = count($request->file('gallery_images'));
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('product_gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
            $changes[] = "Tambah $count foto galeri";
        }

        if (count($changes) > 0) {
            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => 'UPDATE',
                'model_type' => 'Produk',
                'model_name' => $product->name,
                'details'    => implode(', ', $changes),
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $deletedName = $product->name;
        $deletedStock = $product->stock;

        $product->delete();

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'model_type' => 'Produk',
            'model_name' => $deletedName,
            'details'    => "Menyembunyikan produk '{$deletedName}' (Sisa Stok: {$deletedStock}) ke keranjang sampah.",
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil disembunyikan / dihapus aman!');
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        
        $status = $product->is_active ? 'Aktif' : 'Non-Aktif';
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE',
            'model_type' => 'Produk',
            'model_name' => $product->name,
            'details'    => "Mengubah status tampil menjadi: {$status}",
        ]);

        return back()->with('success', 'Status produk diubah.');
    }

    public function destroyImage($id)
    {
        $image = \App\Models\ProductImage::findOrFail($id);
        $productName = $image->product->name; 
        
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE', 
            'model_type' => 'Produk',
            'model_name' => $productName,
            'details'    => "Menghapus 1 foto dari galeri",
        ]);

        return back()->with('success', 'Foto galeri dihapus.');
    }

    private function translateField($field)
    {
        $dictionary = [
            'category_id' => 'Kategori',
            'name'        => 'Nama Produk',
            'description' => 'Deskripsi',
            'price'       => 'Harga',
            'stock'       => 'Stok',
            'weight'      => 'Berat',
            'length'      => 'Panjang',
            'width'       => 'Lebar',
            'height'      => 'Tinggi',
            'is_active'   => 'Status Aktif',
            'is_featured' => 'Status Unggulan',
        ];
        return $dictionary[$field] ?? $field;
    }
}