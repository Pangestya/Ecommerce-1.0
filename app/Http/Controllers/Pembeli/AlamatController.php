<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Halaman Daftar Alamat)
     */


    /**
     * Show the form for creating a new resource.
     * (Halaman Form Tambah)
     */
    public function create()
    {
        // Ambil data provinsi langsung di View pakai JS, jadi di sini kosong aja
        return view('pembeli.alamat.create');
    }

    /**
     * Store a newly created resource in storage.
     * (Proses Simpan ke Database)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',

            'province_id' => 'required',
            'province_name' => 'required|string',

            'city_id' => 'required',
            'city_name' => 'required|string',

            'subdistrict_id' => 'required',
            'subdistrict_name' => 'required|string',

            // village OPTIONAL
            'village_id' => 'nullable',
            'village_name' => 'nullable|string',

            'detail_alamat' => 'required|string',
            'postal_code' => 'nullable|string|max:255',
        ]);
        
        $isFirstAddress = Alamat::where('user_id', Auth::id())->doesntExist();

        Alamat::create([
            'user_id' => Auth::id(),

            'name' => $request->name,
            'phone' => $request->phone,

            'province_id' => $request->province_id,
            'province_name' => $request->province_name,

            'city_id' => $request->city_id,
            'city_name' => $request->city_name,

            'subdistrict_id' => $request->subdistrict_id,
            'subdistrict_name' => $request->subdistrict_name,

            'village_id' => $request->village_id,
            'village_name' => $request->village_name,

            'postal_code' => $request->postal_code,
            'detail_alamat' => $request->detail_alamat,

            'is_primary' => false,
        ]);

        return redirect()->route('pembeli.profile.edit')
            ->with('success', 'Alamat berhasil ditambahkan!');
    }


    /**
     * (Nanti) Hapus Alamat
     */
    public function destroy(string $id)
    {
        $alamat = Alamat::where('user_id', Auth::id())->findOrFail($id);
        $alamat->delete();

        return redirect()->route('pembeli.profile.edit')
            ->with('success', 'Alamat berhasil dihapus.');
    }

    public function edit(string $id)
    {
        // Ambil alamat berdasarkan ID dan pastikan punya User yang sedang login
        $alamat = Alamat::where('user_id', Auth::id())->findOrFail($id);

        return view('pembeli.alamat.edit', compact('alamat'));
    }

public function update(Request $request, string $id)
{
    $alamat = Alamat::where('user_id', Auth::id())->findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:255',

        'province_id' => 'required',
        'province_name' => 'required|string',

        'city_id' => 'required',
        'city_name' => 'required|string',

        'subdistrict_id' => 'required',
        'subdistrict_name' => 'required|string',

        'village_id' => 'nullable',
        'village_name' => 'nullable|string',

        'detail_alamat' => 'required|string',
        'postal_code' => 'nullable|string|max:255',
    ]);

    $alamat->update([
        'name' => $request->name,
        'phone' => $request->phone,

        'province_id' => $request->province_id,
        'province_name' => $request->province_name,

        'city_id' => $request->city_id,
        'city_name' => $request->city_name,

        'subdistrict_id' => $request->subdistrict_id,
        'subdistrict_name' => $request->subdistrict_name,

        'village_id' => $request->village_id,
        'village_name' => $request->village_name,

        'postal_code' => $request->postal_code,
        'detail_alamat' => $request->detail_alamat,
    ]);

    return redirect()->route('pembeli.profile.edit')
        ->with('success', 'Alamat berhasil diperbarui!');
}

public function setPrimary($id)
    {
        $userId = Auth::id();
        
        // 1. Validasi: Pastikan alamat ini milik user yang sedang login
        $alamatBaru = Alamat::where('user_id', $userId)->findOrFail($id);

        // 2. Reset semua alamat user ini jadi Secondary (false)
        Alamat::where('user_id', $userId)->update(['is_primary' => false]);

        // 3. Set alamat yang dipilih jadi Primary (true)
        $alamatBaru->update(['is_primary' => true]);

        return redirect()->back()->with('success', 'Alamat utama berhasil diubah.');
    }

}