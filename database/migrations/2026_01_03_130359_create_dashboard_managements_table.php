<?php
// Jalankan: php artisan make:migration create_dashboard_managements_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Tabel untuk Galeri Foto
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('image_path');
            $table->timestamps();
        });

        // Tabel untuk Teks Statis (Slogan & Deskripsi)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // contoh: 'slogan_utama'
            $table->text('value')->nullable();
             $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('settings');
    }
};