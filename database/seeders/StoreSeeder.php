<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ← ось це додай
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Store::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Store::factory()->create([
            'name' => 'Світ Матраців',
            'url' => 'https://svit-matrasiv.com.ua',
        ]);

        Store::factory()->create([
            'name' => 'Bon Colchón',
            'url' => 'https://boncolchon.com',
        ]);

        Store::factory()->create([
            'name' => 'Munger',
            'url' => 'https://munger.com.ua',
        ]);
    }
}
