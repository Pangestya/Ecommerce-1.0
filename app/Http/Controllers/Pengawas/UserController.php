<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // 1. TAMPILKAN LIST (Hanya Admin & Pengawas, Pembeli Dihilangkan)
    public function index()
    {
        // Filter: Ambil semua user KECUALI role 3 (Pembeli)
        $users = User::where('role', '!=', 3)->latest()->paginate(10);
        return view('pengawas.users.index', compact('users'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('pengawas.users.create');
    }

    // 3. SIMPAN USER (Hanya boleh buat Admin/Pengawas)
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validasi: Hanya menerima input 1 (Admin) atau 2 (Pengawas)
            'role' => ['required', 'integer', 'in:1,2'], 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('pengawas.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 4. FORM EDIT (Proteksi Akses Pembeli)
    public function edit(User $user)
    {
        // Proteksi: Jika Pengawas mencoba akses URL edit untuk Pembeli, tolak.
        if ($user->role == 3) {
            return redirect()->route('pengawas.users.index')->with('error', 'Anda tidak memiliki akses ke data Pembeli.');
        }

        return view('pengawas.users.edit', compact('user'));
    }

    // 5. UPDATE USER
    public function update(Request $request, User $user)
    {
        // Proteksi: Cek lagi user yang sedang diedit
        if ($user->role == 3) {
            return abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255', 
                Rule::unique('users')->ignore($user->id),
            ],
            // Validasi: Hanya boleh update jadi Admin atau Pengawas
            'role' => ['required', 'integer', 'in:1,2'], 
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pengawas.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. HAPUS USER
    public function destroy(User $user)
    {
        // Cek 1: Tidak boleh hapus diri sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Cek 2: Tidak boleh hapus Pembeli
        if ($user->role == 3) {
            return back()->with('error', 'Anda tidak berhak menghapus data Pembeli!');
        }

        $user->delete();
        return redirect()->route('pengawas.users.index')->with('success', 'User berhasil dihapus!');
    }
}