<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zila;

class ZilasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Zila::factory()->count(10)->create();
    }
}
