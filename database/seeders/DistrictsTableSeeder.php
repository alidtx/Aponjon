<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictsTableSeeder extends Seeder
{
    
    public function run(): void
    {
        
        District::factory()->count(10)->create();
    }
}
