<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Info Penerima
            $table->string('name');         // Nama Penerima
            $table->string('phone');        // No HP
            
            // --- DATA LOKASI (DARI API KOMERCE) ---
            $table->unsignedBigInteger('province_id');
            $table->string('province_name');
            
            $table->unsignedBigInteger('city_id');
            $table->string('city_name');
            
            $table->unsignedBigInteger('subdistrict_id'); // ID Kecamatan (Penting!)
            $table->string('subdistrict_name');           // Nama Kecamatan
            
            // --- DATA MANUAL ---
            $table->string('postal_code')->nullable(); // Kode Pos
            $table->text('detail_alamat');  // Jalan, RT/RW, No Rumah (Saya ganti jadi detail_alamat biar Indo banget)
            
            // Penanda Alamat Utama
            $table->boolean('is_primary')->default(false);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alamats');
    }
};