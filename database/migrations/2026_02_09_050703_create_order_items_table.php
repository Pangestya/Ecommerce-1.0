<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignUlid('product_id')->constrained('products');
            
            // Snapshot Data 
            $table->string('product_name'); 
            $table->integer('quantity');
            $table->integer('price');       // Harga saat beli
            $table->integer('subtotal');    // quantity * price
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};