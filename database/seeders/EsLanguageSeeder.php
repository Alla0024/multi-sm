<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class EsLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::factory()->create([
            'code' => 'es',
            'path' => 'es',
            'status' => true,
            'sort_order' => 2
        ]);
    }
}
