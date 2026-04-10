<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Kategori: Pembayaran
            [
                'category' => 'pembayaran',
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Kami menerima pembayaran melalui Transfer Bank (Virtual Account), E-Wallet (GoPay, OVO, ShopeePay), dan QRIS.'
            ],
            [
                'category' => 'pembayaran',
                'question' => 'Berapa lama batas waktu pembayaran?',
                'answer' => 'Batas waktu pembayaran adalah 60 menit setelah pesanan dibuat. Jika melewati batas tersebut, pesanan otomatis dibatalkan.'
            ],
            
            // Kategori: Pengiriman
            [
                'category' => 'pengiriman',
                'question' => 'Kapan pesanan saya dikirim?',
                'answer' => 'Pesanan akan diproses dan dikirim maksimal 1x24 jam setelah pembayaran terkonfirmasi lunas.'
            ],
            [
                'category' => 'pengiriman',
                'question' => 'Bagaimana cara melacak pesanan?',
                'answer' => 'Buka menu "Riwayat Pesanan", pilih pesanan yang sedang dikirim, lalu klik tombol "Detail". Nomor resi akan tertera di sana.'
            ],

            // Kategori: Umum
            [
                'category' => 'umum',
                'question' => 'Apakah bisa COD (Bayar di Tempat)?',
                'answer' => 'Saat ini kami belum mendukung fitur COD. Semua transaksi dilakukan secara non-tunai demi keamanan.'
            ],
        ];

        foreach ($data as $item) {
            Faq::create($item);
        }
    }
}