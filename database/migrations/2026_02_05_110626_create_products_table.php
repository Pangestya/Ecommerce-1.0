<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        // Audit Trail
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

        // Info Dasar
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('stock');
        
        // --- DATA PENGIRIMAN (RAJAONGKIR) ---
        $table->integer('weight'); // Gram (Wajib)
        $table->integer('length')->nullable(); // cm
        $table->integer('width')->nullable();  // cm
        $table->integer('height')->nullable(); // cm
        // -----------------------------------

        $table->string('image')->nullable(); // Foto Utama (Cover)
        
        // Status
        $table->boolean('is_active')->default(true);
        $table->boolean('is_featured')->default(false);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
