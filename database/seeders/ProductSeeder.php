<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoffeeBean;
use App\Models\Merchandise;
use App\Models\Outlet;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA BIJI KOPI (Global)
        $arabica = CoffeeBean::updateOrCreate(
            ['name' => 'Arabica Gayo Wine'],
            [
                'origin' => 'Aceh',
                'global_stock_kg' => 50,
                'price_250g' => 120000.00,
            ]
        );

        $robusta = CoffeeBean::updateOrCreate(
            ['name' => 'Robusta Dampit'],
            [
                'origin' => 'Malang',
                'global_stock_kg' => 80,
                'price_250g' => 95000.00,
            ]
        );

        // 2. DATA MERCHANDISE
        // Ambil kategori secara dinamis (Cari yang pertama ditemukan dengan nama tersebut)
        $catAksesoris = Category::where('name', 'LIKE', '%Aksesoris%')->first();
        $catPakaian = Category::where('name', 'LIKE', '%Pakaian%')->first();

        if (!$catAksesoris || !$catPakaian) {
            $this->command->error("Kategori 'Aksesoris' atau 'Pakaian' belum ada. Pastikan CategorySeeder sudah dijalankan.");
            return;
        }

        $tumbler = Merchandise::updateOrCreate(
            ['name' => 'Tumbler Zocco Signature'],
            [
                'category_id' => $catAksesoris->id,
                'global_stock_unit' => 150,
                'price' => 225000.00,
            ]
        );

        $kaos = Merchandise::updateOrCreate(
            ['name' => 'Kaos Zocco Series'],
            [
                'category_id' => $catPakaian->id,
                'global_stock_unit' => 200,
                'price' => 150000.00,
            ]
        );

        // 3. PENGISIAN STOK OUTLET (Relasi Many-to-Many)
        // Kita ambil semua outlet agar mendapatkan Hash ID mereka
        $zoccoH = Outlet::where('name', 'LIKE', '%Zocco Heritage%')->first();
        $madbaker = Outlet::where('name', 'LIKE', '%Madbaker%')->first(); 

        // Sinkronisasi stok menggunakan ID Hash yang didapat dari database
        if ($zoccoH && $madbaker) {
            // Sinkronisasi Biji Kopi ke Outlet
            $arabica->outlets()->sync([
                $zoccoH->id => ['stock_kg' => 15],
                $madbaker->id => ['stock_kg' => 10],
            ]);

            // Sinkronisasi Merchandise ke Outlet
            $tumbler->outlets()->sync([
                $zoccoH->id => ['stock_unit' => 50],
                $madbaker->id => ['stock_unit' => 40],
            ]);
            
            $this->command->info("Stok produk berhasil disinkronkan ke Outlet.");
        } else {
            $this->command->warn("Beberapa outlet tidak ditemukan, stok tidak disinkronkan.");
        }
    }
}