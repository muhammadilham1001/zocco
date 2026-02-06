<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\MenuSeeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Pastikan penulisan $this->call seperti ini
        $this->call([
            OutletSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}