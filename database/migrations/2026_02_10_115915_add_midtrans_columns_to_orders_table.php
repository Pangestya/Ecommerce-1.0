<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kita tambahkan kolom yang kurang saja
            // nullable() artinya boleh kosong (penting agar data lama tidak error)
            
            $table->string('invoice_number')->nullable()->after('id');
            $table->string('midtrans_booking_code')->nullable()->after('invoice_number');
            $table->string('etd')->nullable()->after('total_weight'); // Estimasi hari
            $table->text('notes')->nullable()->after('status');
            
            // Kolom snap_token sepertinya sudah ada di file lama Anda, 
            // tapi kalau belum ada, uncomment baris di bawah ini:
            // $table->string('snap_token')->nullable()->after('midtrans_booking_code');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kalau di-rollback, kolom ini dihapus
            $table->dropColumn(['invoice_number', 'midtrans_booking_code', 'etd', 'notes']);
        });
    }
};