<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $outlets = [
        [
            'name' => 'Zocco Heritage', 
            'city' => 'Jl. Jaksa Agung Suprapto No. 34, Klojen, Kota Malang.',
            'email' => 'heritage@zocco.com' 
        ],
        [
            'name' => 'Madbaker', 
            'city' => 'Jl. Perumahan Bukit Cemara Tidar, Karangbesuki, Kecamatan Sukun, Kota Malang.',
            'email' => 'madbaker@zocco.com'
        ],
        [
            'name' => 'Zocco Sulfat', 
            'city' => 'Jl. Sulfat No.10, Purwantoro, Kec. Blimbing, Kota Malang.',
            'email' => 'sulfat@zocco.com'
        ],
        [
            'name' => 'Zocco Elpico', 
            'city' => 'Jl. Villa Puncak Tidar, Lowokwaru, Kota Malang.',
            'email' => 'elpico@zocco.com'
        ],
    ];

    foreach ($outlets as $outlet) {
        Outlet::create($outlet);
    }
}
}