<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\AuditLog; // Pastikan model ini ada
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengawasController extends Controller
{
    public function index()
    {
        // --- 1. KARTU RINGKASAN (BULAN INI) ---
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Data Orders Bulan Ini
        $ordersThisMonth = Order::where('created_at', '>=', $startOfMonth)->get();
        
        // A. Pendapatan Bersih (Completed Only)
        $completedOrders = $ordersThisMonth->where('status', 'completed');
        $netRevenue = $completedOrders->sum('grand_total') - $completedOrders->sum('shipping_cost');
        
        // B. Volume Transaksi
        $totalCompleted = $completedOrders->count();

        // C. Perlu Perhatian (Unshipped: Paid & Processing) - Total Semua Waktu (bukan cuma bulan ini)
        $unshippedCount = Order::whereIn('status', ['paid', 'processing'])->count();

        // D. Tingkat Pembatalan (Cancel Rate)
        $totalAllOrders = $ordersThisMonth->count();
        $cancelledCount = $ordersThisMonth->where('status', 'cancelled')->count();
        $cancelRate = $totalAllOrders > 0 ? ($cancelledCount / $totalAllOrders) * 100 : 0;


        // --- 2. GRAFIK TREN (7 HARI TERAKHIR) ---
        $chartDates = [];
        $chartRevenue = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            
            // Hitung revenue bersih per hari
            $revenue = Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->get()
                ->sum(function($order) {
                    return $order->grand_total - $order->shipping_cost;
                });
            
            $chartRevenue[] = $revenue;
        }

        // --- 3. AUDIT LOG TERBARU ---
        // Mengambil 5 aktivitas terakhir admin/staff
        $recentActivities = AuditLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        // --- 4. TOP PRODUK & STOK MENIPIS ---
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->take(5)->get();

        return view('pengawas.dashboard', compact(
            'netRevenue', 'totalCompleted', 'unshippedCount', 'cancelRate',
            'chartDates', 'chartRevenue',
            'recentActivities',
            'topProducts', 'lowStockProducts'
        ));
    }
}