<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskerProfile;

class TaskerProfileTableSeeder extends Seeder
{
    
    public function run(): void
    {
        
        TaskerProfile::factory()->count(10)->create();
    }
}
