<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem; // Pastikan Model ini di-import
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Default value jika belum ada filter
        $completedOrders = collect([]);
        $cancelledOrders = collect([]);
        $unshippedOrders = collect([]);
        $grossRevenue = 0;
        $netRevenue = 0;
        $totalTransactions = 0;
        $topProducts = collect([]);
        $courierStats = collect([]);

        if ($startDate && $endDate) {
            // Ambil Data & Hitung Statistik (Logika dipisah ke private function agar rapi)
            $data = $this->getReportData($startDate, $endDate);
            
            // Extract variable dari array
            $completedOrders = $data['completedOrders'];
            $cancelledOrders = $data['cancelledOrders'];
            $unshippedOrders = $data['unshippedOrders'];
            $grossRevenue = $data['grossRevenue'];
            $netRevenue = $data['netRevenue'];
            $totalTransactions = $data['totalTransactions'];
            $topProducts = $data['topProducts'];
            $courierStats = $data['courierStats'];
        }

        return view('pengawas.reports.index', compact(
            'startDate', 'endDate',
            'completedOrders', 'cancelledOrders', 'unshippedOrders',
            'grossRevenue', 'netRevenue', 'totalTransactions',
            'topProducts', 'courierStats'
        ));
    }

    public function print(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // 1. AMBIL SEMUA DATA DALAM RANGE TANGGAL
        // Eager load relasi agar hemat query
        $allOrders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        // 2. PILAH DATA BERDASARKAN STATUS
        
        // A. Data Completed (Untuk Analisis Keuangan & Statistik)
        $completedOrders = $allOrders->where('status', 'completed');
        
        // B. Data Cancelled (Untuk Laporan Pembatalan)
        $cancelledOrders = $allOrders->where('status', 'cancelled');

        // C. Data Unshipped (Paid & Processing) - Yang harus segera dikirim
        $unshippedOrders = $allOrders->whereIn('status', ['paid', 'processing']);


        // 3. HITUNG STATISTIK (Hanya dari Completed Orders)
        $grossRevenue = $completedOrders->sum('grand_total');
        $totalShipping = $completedOrders->sum('shipping_cost'); // Sesuaikan nama kolom ongkir
        $netRevenue = $grossRevenue - $totalShipping;
        $totalTransactions = $completedOrders->count();
        $averageOrderValue = $totalTransactions > 0 ? $grossRevenue / $totalTransactions : 0;

        // 4. TOP PRODUK (Query khusus agar grouping lebih akurat di database level)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_revenue'))
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        // 5. STATISTIK KURIR
        $courierStats = $completedOrders->groupBy('shipping_service')->map(function ($row) {
            return $row->count();
        });

        // 6. GENERATE PDF
        $pdf = Pdf::loadView('pengawas.reports.pdf', compact(
            'startDate', 'endDate',
            'completedOrders', 'cancelledOrders', 'unshippedOrders',
            'grossRevenue', 'netRevenue', 'totalShipping', 'totalTransactions', 'averageOrderValue',
            'topProducts', 'courierStats'
        ));
        
        // Gunakan landscape agar tabel rincian muat banyak kolom
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Lengkap-Pengawas.pdf');
    }

    private function getReportData($startDate, $endDate)
    {
        $allOrders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $completedOrders = $allOrders->where('status', 'completed');
        $cancelledOrders = $allOrders->where('status', 'cancelled');
        $unshippedOrders = $allOrders->whereIn('status', ['paid', 'processing']);

        $grossRevenue = $completedOrders->sum('grand_total');
        $totalShipping = $completedOrders->sum('shipping_cost');
        $netRevenue = $grossRevenue - $totalShipping;
        $totalTransactions = $completedOrders->count();
        $averageOrderValue = $totalTransactions > 0 ? $grossRevenue / $totalTransactions : 0;

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_revenue'))
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        $courierStats = $completedOrders->groupBy('shipping_service')->map(function ($row) {
            return $row->count();
        });

        return compact(
            'completedOrders', 'cancelledOrders', 'unshippedOrders',
            'grossRevenue', 'netRevenue', 'totalShipping', 'totalTransactions', 'averageOrderValue',
            'topProducts', 'courierStats'
        );
    }
}