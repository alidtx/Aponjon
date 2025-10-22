<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceTableSeeder extends Seeder
{
    public function run(): void
    {
        Service::factory()->count(10)->create();
    }
}
