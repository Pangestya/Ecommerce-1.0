<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AuditLog; // <--- WAJIB
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

    // --- 1. STORE (TAMBAH PRODUK DETAILED) ---
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

        // AUDIT TRAIL: CREATE
        // Kita catat info vitalnya saja agar tidak kepanjangan
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

    // --- 2. UPDATE (EDIT PRODUK SUPER DETAIL) ---
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

        // Assign data baru ke object (tanpa save dulu)
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

        // LOGIKA DETEKSI PERUBAHAN
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
                    // Khusus kategori, kita ambil nama kategorinya biar enak dibaca
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

        // AUDIT TRAIL: UPDATE
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

    // --- 3. DESTROY (HAPUS PRODUK) ---
    public function destroy(Product $product)
    {
        // Simpan info penting sebelum dihapus
        $deletedName = $product->name;
        $deletedStock = $product->stock;

        // Hapus file fisik
        if ($product->image) Storage::disk('public')->delete($product->image);
        foreach($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        
        $product->delete();

        // AUDIT TRAIL: DELETE
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'model_type' => 'Produk',
            'model_name' => $deletedName,
            'details'    => "Menghapus produk '{$deletedName}' (Sisa Stok: {$deletedStock}) dari database.",
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus!');
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        
        // Audit Toggle
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
        $productName = $image->product->name; // Ambil nama produknya dulu
        
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        // Audit Hapus Foto Galeri
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE', // Masuk kategori update produk
            'model_type' => 'Produk',
            'model_name' => $productName,
            'details'    => "Menghapus 1 foto dari galeri",
        ]);

        return back()->with('success', 'Foto galeri dihapus.');
    }

    // Helper Translate
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