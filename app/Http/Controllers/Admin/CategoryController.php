<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\AuditLog; // <--- WAJIB
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    // --- 1. STORE (TAMBAH KATEGORI) ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // AUDIT TRAIL: CREATE
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'model_type' => 'Kategori',
            'model_name' => $category->name,
            'details'    => "Menambahkan kategori baru: '{$category->name}'",
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // --- 2. UPDATE (EDIT KATEGORI DETAIL) ---
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Assign data baru (Tanpa Save dulu)
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        // LOGIKA DETEKSI PERUBAHAN
        $changes = [];
        if ($category->isDirty('name')) { // Cek apakah nama berubah?
            $oldName = $category->getOriginal('name');
            $newName = $category->name;
            $changes[] = "Nama Kategori: '$oldName' -> '$newName'";
        }

        $category->save(); // Simpan

        // AUDIT TRAIL: UPDATE (Hanya catat jika ada perubahan)
        if (count($changes) > 0) {
            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => 'UPDATE',
                'model_type' => 'Kategori',
                'model_name' => $category->name,
                'details'    => implode(', ', $changes),
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui!');
    }

    // --- 3. DESTROY (HAPUS KATEGORI) ---
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada produk di kategori ini.');
        }

        $deletedName = $category->name; // Simpan nama dulu
        $category->delete();

        // AUDIT TRAIL: DELETE
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'model_type' => 'Kategori',
            'model_name' => $deletedName,
            'details'    => "Menghapus kategori '{$deletedName}' secara permanen.",
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus!');
    }
}