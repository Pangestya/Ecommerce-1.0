<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PembeliProfileController extends Controller
{
    // Tampilkan Halaman
    public function edit(Request $request)
    {
        return view('pembeli.profile.edit', [
            'user' => $request->user(),
            'alamats' => $request->user()->alamats 
        ]);
    }

    // Proses Update Data
    public function update(Request $request)
    {

    
        $user = $request->user();

        // 1. Validasi
        $request->validate([
            // Username boleh sama kalau punya diri sendiri, tapi ga boleh sama kayak orang lain
            'username' => ['nullable', 'string', 'alpha_dash', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'gender'   => 'nullable|in:Laki-laki,Perempuan',
            'birthday' => 'nullable|date',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        // 2. Logika Upload Foto (Avatar)
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (biar server gak penuh)
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            // Simpan foto baru ke folder 'avatars' di storage public
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Simpan Data Lainnya
        $user->username = $request->username;
        $user->name     = $request->name;
        $user->phone    = $request->phone;
        $user->gender   = $request->gender;
        $user->birthday = $request->birthday;
        
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}