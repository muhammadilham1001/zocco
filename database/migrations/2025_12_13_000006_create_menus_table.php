<?php
// YYYY_MM_DD_HHMMSS_create_menus_table.php
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
    Schema::create('menus', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Outlet (Gunakan String karena Outlet pakai Hash)
            $table->string('outlet_id');
            
            // Relasi ke Category (Tetap pakai foreignId karena Category pakai ID Angka)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->string('name');
            // TAMBAHKAN INI: Untuk membedakan logika pilihan nanti
            $table->enum('type', ['makanan', 'minuman'])->default('makanan');
            $table->boolean('allow_custom_note')->default(false);
            // Untuk Minuman
            $table->boolean('allow_ice_sugar_level')->default(false);
            
            // Untuk Makanan
            $table->boolean('allow_egg_option')->default(false);
            $table->boolean('allow_spicy_option')->default(false);
            $table->string('image_url')->nullable(); 
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('is_available')->default(true); // Status Stok

            $table->timestamps();

            // Foreign Key untuk Outlet
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
        Schema::dropIfExists('menus');
    }
};