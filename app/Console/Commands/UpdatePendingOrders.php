<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Product; // Pastikan import Product
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Transaction;

class UpdatePendingOrders extends Command
{
    protected $signature = 'orders:update-status';
    protected $description = 'Cek status pesanan pending dan kembalikan stok jika expire/kabur';

    public function handle()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Cari order yang pending
        $orders = Order::with('items')
                        ->where('status', 'pending')
                        ->whereNotNull('midtrans_booking_code')
                        ->get();

        $this->info("Memeriksa " . $orders->count() . " pesanan pending...");

        foreach ($orders as $order) {
            try {
                // Cek status di Midtrans
                $status = Transaction::status($order->midtrans_booking_code);

                // 1. Jika EXPIRE / CANCEL / DENY
                if (in_array($status->transaction_status, ['expire', 'cancel', 'deny'])) {
                    $this->cancelOrder($order, "Midtrans Status: " . $status->transaction_status);
                } 
                // 2. Jika LUNAS
                else if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $order->update(['status' => 'paid']);
                    $this->info("Order #{$order->invoice_number} LUNAS.");
                }

            } catch (\Exception $e) {
                // 3. Jika Error 404 (Ghost Order / Transaksi Gak Ada di Midtrans)
                $is404 = $e->getCode() == 404 || strpos($e->getMessage(), '404') !== false;

                if ($is404) {
                    // Cek umur order (menit)
                    $durasi = now()->diffInMinutes($order->created_at, true);

                    // Jika sudah > 60 menit menggantung tanpa kejelasan -> Batalkan
                    if ($durasi >= 60) { 
                        $this->cancelOrder($order, "Tidak Melanjutkan Pembayaran atau Belum Memilih Metode Pemabayaran (Expired > 60 menit).");
                    }
                }
            }
        }
    }

    // Fungsi Batalkan Order & Balikin Stok
    private function cancelOrder($order, $reason) {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity); // Balikin Stok
                }
            }
            $order->update(['status' => 'cancelled']);
        });
        
        $this->info("Order #{$order->invoice_number} DIBATALKAN. Alasan: $reason");
    }
}