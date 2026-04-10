<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $orders = collect([]);
        $grossRevenue = 0; // Pendapatan Kotor (Termasuk Ongkir)
        $netRevenue = 0;   // Pendapatan Bersih (Tanpa Ongkir)

        if ($startDate && $endDate) {
            // 1. AMBIL SEMUA DATA (Paid, Processing, Shipped, Completed)
            // Agar di tabel tetap terlihat semua history-nya
            $orders = Order::with(['user', 'items.product'])
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->whereIn('status', ['paid', 'processing', 'shipped', 'completed']) 
                ->latest()
                ->get();

            // 2. HITUNG HANYA YANG COMPLETED
            // Filter data di memory (Collection) tanpa query ulang
            $completedOrders = $orders->where('status', 'completed');

            // Total Kotor (Grand Total)
            $grossRevenue = $completedOrders->sum('grand_total');

            // Total Bersih (Grand Total - Ongkir)
            // Pastikan ganti 'shipping_cost' sesuai nama kolom ongkir di DB Anda!
            $netRevenue = $completedOrders->sum(function ($order) {
                return $order->grand_total - $order->shipping_cost; 
            });
        }

        return view('admin.reports.index', compact('orders', 'grossRevenue', 'netRevenue', 'startDate', 'endDate'));
    }

    public function print(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // Ambil Data Sama seperti Index
        $orders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])
            ->latest()
            ->get();

        // Hitung Logika Completed
        $completedOrders = $orders->where('status', 'completed');
        $grossRevenue = $completedOrders->sum('grand_total');
        
        // Hitung Bersih
        $netRevenue = $completedOrders->sum(function ($order) {
            return $order->grand_total - $order->shipping_cost; 
        });

        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'grossRevenue', 'netRevenue', 'startDate', 'endDate'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Penjualan.pdf');
    }
}