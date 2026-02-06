<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name'     => 'Administrator Zocco',
            'email'    => 'ilahamh3@gmail.com',
            'password' => Hash::make('admin123'), // Ganti password sesuai keinginan
            'role'     => 'admin',
        ]);

        // Membuat Akun User Contoh (Opsional)
        User::create([
            'name'     => 'ilham',
            'email'    => 'ilhmvfx@gmail.com',
            'password' => Hash::make('12345678'),
            'role'     => 'user',
        ]);
    }
}