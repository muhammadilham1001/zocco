<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil outlet berdasarkan nama agar mendapatkan ID Hash yang benar
        $zocco = Outlet::where('name', 'LIKE', '%Zocco Heritage%')->first();
        $madbaker = Outlet::where('name', 'LIKE', '%Madbaker%')->first();

        // 2. Cek apakah outlet ditemukan untuk menghindari error "null"
        if ($zocco) {
            Category::create(['outlet_id' => $zocco->id, 'name' => 'Coffee']);
            Category::create(['outlet_id' => $zocco->id, 'name' => 'Pastry']);
        }

        if ($madbaker) {
            Category::create(['outlet_id' => $madbaker->id, 'name' => 'Manual Brew']);
            Category::create(['outlet_id' => $madbaker->id, 'name' => 'Dessert']);
        }
    }
}