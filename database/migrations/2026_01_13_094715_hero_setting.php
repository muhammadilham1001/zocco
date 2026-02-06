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
    Schema::create('hero_settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // Contoh: 'hero_bg', 'hero_title', 'hero_subtitle'
        $table->text('value')->nullable();
        $table->string('image')->nullable(); // Untuk menyimpan path gambar parallax
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
