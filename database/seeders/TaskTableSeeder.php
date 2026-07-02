<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    public function run(): void
    {
        Task::factory()->count(24)->create();
    }
}
