<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1); // Bedanya sama wishlist cuma disini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};