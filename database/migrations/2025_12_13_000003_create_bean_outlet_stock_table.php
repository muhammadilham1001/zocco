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
        Schema::create('bean_outlet_stock', function (Blueprint $table) {
            // Coffee Bean tetap pakai foreignId karena ID-nya integer standar
            $table->foreignId('coffee_bean_id')->constrained()->onDelete('cascade');
            
            // PERUBAHAN: outlet_id harus string untuk menampung Hash
            $table->string('outlet_id');
            
            // Kolom Stok (Gunakan decimal jika ingin mendukung angka seperti 1.5 kg)
            $table->decimal('stock_kg', 8, 2); 
            
            // Primary Key gabungan
            $table->primary(['coffee_bean_id', 'outlet_id']);
            $table->timestamps();

            // Definisi Foreign Key manual untuk outlet_id
            $table->foreign('outlet_id')
                  ->references('id')
                  ->on('outlets')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bean_outlet_stock');
    }
};