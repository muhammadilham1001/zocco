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
        Schema::create('merchandise_outlet_stock', function (Blueprint $table) {
            // Merchandise tetap pakai foreignId karena ID-nya integer standar
            $table->foreignId('merchandise_id')->constrained()->onDelete('cascade');
            
            // PERUBAHAN: outlet_id harus string karena merujuk ke Hash ID
            $table->string('outlet_id');
            
            // Kolom Stok
            $table->unsignedInteger('stock_unit'); 
            
            // Menentukan pasangan ID sebagai Primary Key
            $table->primary(['merchandise_id', 'outlet_id']);
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
        Schema::dropIfExists('merchandise_outlet_stock');
    }
};