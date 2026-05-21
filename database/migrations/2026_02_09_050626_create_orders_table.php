<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade');
            
            // Info Penerima (Snapshot)
            $table->string('name');         
            $table->string('phone');        
            $table->text('address_detail'); 
            
            // Info Lokasi (Penting buat laporan ongkir)
            $table->string('subdistrict');  // Kecamatan
            $table->string('city');         // Kota/Kab
            $table->string('province');     // Provinsi
            $table->string('postal_code');  

            // Info Pengiriman
            $table->string('courier');          // jne/sicepat/dll
            $table->string('shipping_service'); // REG/OKE/YES
            $table->integer('shipping_cost');   // Biaya Ongkir
            $table->integer('total_weight');    // Berat Total (gram)

            // Info Pembayaran
            $table->integer('subtotal');        // Harga Barang
            $table->bigInteger('grand_total');  // Total Bayar (Barang + Ongkir)
            $table->string('status')->default('pending'); // pending, paid, sent, cancelled, done
            
            // Midtrans
            $table->string('snap_token')->nullable(); // Token pembayaran

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};