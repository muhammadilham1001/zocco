<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coffee_beans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Arabica Gayo Wine
            $table->string('origin');        // Contoh: Aceh
            $table->decimal('price_250g', 12, 2); // Contoh: 120000.00
            $table->unsignedInteger('global_stock_kg'); // Contoh: 50
            $table->text('description')->nullable(); // Opsional untuk detail produk
            $table->string('image_url')->nullable(); // Opsional jika ingin ada gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coffee_beans');
    }
};