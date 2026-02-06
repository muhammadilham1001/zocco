<?php
// Jalankan: php artisan make:seeder SettingSeeder
namespace Database\Seeders;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    public function run() {
        Setting::create([
            'key' => 'slogan_utama',
            'value' => 'Tempat Ngopi Terbaik di Kota'
        ]);
        Setting::create([
            'key' => 'deskripsi_singkat',
            'value' => 'Kami menyajikan kopi terbaik dari biji pilihan lokal dengan suasana yang nyaman.'
        ]);
    }
}