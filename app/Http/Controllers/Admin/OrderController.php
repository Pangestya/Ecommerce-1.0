<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Daftar Pesanan
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter Status (Opsional)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // 2. Tampilkan Detail Pesanan
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Update Status: Diproses (Dikemas)
    public function process($id)
    {
        $order = Order::findOrFail($id);
        
        // Hanya bisa diproses kalau statusnya sudah 'paid'
        if ($order->status == 'paid') {
            $order->update(['status' => 'processing']);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => 'UPDATE',
                'model_type' => 'Pesanan',
                'model_name' => "Order #{$order->id}",
                'details'    => "Mengubah status pesanan menjadi 'Sedang Dikemas'",
            ]);

            return back()->with('success', 'Status pesanan diubah menjadi Sedang Dikemas.');
        }

        return back()->with('error', 'Pesanan belum dibayar atau status tidak valid.');
    }

    // 4. Update Status: Dikirim (Input Resi)
    public function send(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string|max:50'
        ]);

        $order = Order::findOrFail($id);

        if (in_array($order->status, ['paid', 'processing'])) {
            $order->update([
                'status' => 'shipped',
                'resi_number' => $request->resi_number
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => 'UPDATE',
                'model_type' => 'Pesanan',
                'model_name' => "Order #{$order->id}",
                'details'    => "Pesanan dikirim. Input No. Resi: {$request->resi_number}",
            ]);

            return back()->with('success', 'Pesanan berhasil dikirim! Resi telah disimpan.');
        }

        return back()->with('error', 'Status pesanan tidak valid untuk pengiriman.');
    }
}