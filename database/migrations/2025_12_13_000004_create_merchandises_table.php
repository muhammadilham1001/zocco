<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Tumbler Zocco Signature
            
            // Menggunakan string jika kategori sederhana, 
            // atau foreignId jika Anda punya tabel 'categories' terpisah
            $table->string('category'); // Contoh: Aksesoris, Pakaian
            
            $table->decimal('price', 12, 2); // Contoh: 225000.00
            $table->unsignedInteger('global_stock_unit'); // Contoh: 150
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchandises');
    }
};