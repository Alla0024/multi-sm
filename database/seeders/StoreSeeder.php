<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::factory()->create([
            'name' => 'Світ Матраців',
            'url' => 'https://svit-matrasiv.com.ua',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Store::factory()->create([
            'name' => 'Bon Colchón',
            'url' => 'https://boncolchon.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Store::factory()->create([
            'name' => 'Munger',
            'url' => 'https://munger.com.ua',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
