<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Upozila;

class UpozilasTableSeeder extends Seeder
{
    
    public function run(): void
    {
        Upozila::factory()->count(10)->create();
    }
}
