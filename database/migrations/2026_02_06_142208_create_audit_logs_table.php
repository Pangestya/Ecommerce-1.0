<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade'); // Siapa pelakunya?
            $table->string('action');      // CREATE, UPDATE, DELETE, LOGIN
            $table->string('model_type');  // Produk, Kategori, User
            $table->string('model_name');  // Nama itemnya (Misal: "Sepatu Nike")
            $table->text('details')->nullable(); // Detail perubahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};