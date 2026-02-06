<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel reservations
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            
            // Menghubungkan ke tabel menus
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('price_at_order', 12, 2); // Menyimpan harga saat dipesan (jika nanti harga menu berubah)
            
            // Menyimpan pilihan kustom (telur, pedas, ice, sugar)
            $table->string('options')->nullable(); 
            $table->text('note')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_items');
    }
};