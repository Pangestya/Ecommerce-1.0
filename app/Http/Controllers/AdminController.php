<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA (TO-DO LIST)
        // Pesanan yang HARUS segera diproses (Paid) dan dikirim (Processing)
        $ordersToProcess = Order::where('status', 'paid')->count();
        $ordersToShip = Order::where('status', 'processing')->count();
        
        // Total Produk & Pelanggan
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'pembeli')->count(); // Asumsi ada kolom role

        // 2. PESANAN TERBARU (5 Transaksi Terakhir)
        // Agar admin bisa langsung klik detail tanpa masuk menu pesanan
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // 3. PERINGATAN STOK (Operational Alert)
        // Admin butuh ini untuk segera restock
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // 4. GRAFIK SEDERHANA (Order Masuk 7 Hari Terakhir)
        $chartDates = [];
        $chartOrders = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            $chartOrders[] = Order::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'ordersToProcess', 'ordersToShip', 'totalProducts', 'totalCustomers',
            'recentOrders', 'lowStockProducts',
            'chartDates', 'chartOrders'
        ));
    }
}