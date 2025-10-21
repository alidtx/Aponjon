<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Upozila;

class UpozilasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Upozila::factory()->count(30)->create();
    }
}
