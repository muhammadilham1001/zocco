<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Outlet; 
use App\Models\Category;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Model Outlet secara dinamis agar mendapatkan Hash ID yang benar
        $zocco = Outlet::where('name', 'LIKE', '%Zocco Heritage%')->first();
        $madbaker = Outlet::where('name', 'LIKE', '%Madbaker%')->first();

        // 2. Ambil ID Kategori
        $catCoffee = Category::where('name', 'Coffee')->first();
        $catPastry = Category::where('name', 'Pastry')->first();

        // Safety check
        if (!$zocco || !$madbaker || !$catCoffee || !$catPastry) {
            echo "Error: Pastikan OutletSeeder dan CategorySeeder sudah dijalankan lebih dulu.\n";
            return;
        }

        // ==========================================================
        // --- DATA MENU UNTUK ZOCCO HERITAGE ---
        // ==========================================================
        Menu::create([
            'outlet_id' => $zocco->id, // Menggunakan Hash ID dari database
            'category_id' => $catCoffee->id,
            'name' => 'Espresso Hot',
            'image_url' => 'uploads/menu/espresso.jpg', // Sesuaikan path folder storage Anda
            'description' => 'Single shot espresso dari Gayo Wine Bean.',
            'price' => 25000,
            'is_available' => 1,
        ]);
        
        Menu::create([
            'outlet_id' => $zocco->id,
            'category_id' => $catPastry->id,
            'name' => 'Cheese Croissant',
            'image_url' => 'uploads/menu/cheese_croissant.jpg',
            'description' => 'Croissant renyah dengan isian keju cheddar.',
            'price' => 32000,
            'is_available' => 1,
        ]);
        
        // ==========================================================
        // --- DATA MENU UNTUK MADBAKER ---
        // ==========================================================
        Menu::create([
            'outlet_id' => $madbaker->id, // Menggunakan Hash ID dari database
            'category_id' => $catCoffee->id,
            'name' => 'Madbaker Signature Blend',
            'image_url' => 'uploads/menu/signature_coffee.jpg',
            'description' => 'Kopi signature Madbaker.',
            'price' => 40000,
            'is_available' => 1,
        ]);
    }
}