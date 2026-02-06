<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Penting: Harus string agar cocok dengan id di tabel outlets
            $table->string('outlet_id');
            $table->string('name');
            $table->timestamps();

            // Definisi Foreign Key manual
            $table->foreign('outlet_id')
                  ->references('id')
                  ->on('outlets')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};