<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    public function run(): void
    {
        Service::factory()->count(16)->create();
    }
}
