<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // HAPUS unique(), TAMBAH nullable()
            // nullable() penting biar data user lama nggak error saat kolom ini dibuat
            $table->string('username')->nullable()->after('id'); 
            
            // Kolom pelengkap lainnya (tetap nullable biar aman)
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone')->nullable()->after('avatar');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('phone');
            $table->date('birthday')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kalau di-rollback, hapus kolom-kolom ini
            $table->dropColumn(['username', 'avatar', 'phone', 'gender', 'birthday']);
        });
    }
};