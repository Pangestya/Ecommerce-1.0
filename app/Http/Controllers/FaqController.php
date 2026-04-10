<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori unik untuk tombol di atas
        $categories = [
            ['id' => 'umum', 'label' => 'Informasi Umum', 'icon' => 'fa-info-circle', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
            ['id' => 'akun', 'label' => 'Akun & Keamanan', 'icon' => 'fa-user-shield', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50'],
            ['id' => 'pembayaran', 'label' => 'Pembayaran', 'icon' => 'fa-wallet', 'color' => 'text-yellow-500', 'bg' => 'bg-yellow-50'],
            ['id' => 'pengiriman', 'label' => 'Pesanan & Pengiriman', 'icon' => 'fa-truck', 'color' => 'text-green-500', 'bg' => 'bg-green-50'],
            ['id' => 'pengembalian', 'label' => 'Pengembalian Dana', 'icon' => 'fa-undo', 'color' => 'text-red-500', 'bg' => 'bg-red-50'],
            ['id' => 'layanan', 'label' => 'Layanan Pelanggan', 'icon' => 'fa-headset', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50'],
        ];

        // Ambil FAQ dari database
        $query = Faq::where('is_active', true);

        // Jika user klik salah satu kategori
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $faqs = $query->get();

        return view('pembeli.bantuan', compact('categories', 'faqs'));
    }
}