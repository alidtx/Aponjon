<?php

namespace Database\Seeders;

use App\Models\TaskerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskerProfileTableSeeder extends Seeder
{
    public function run(): void
    {
        $taskerIds = User::query()
            ->where('role', 'tasker')
            ->pluck('id');

        foreach ($taskerIds as $taskerId) {
            TaskerProfile::factory()->create([
                'user_id' => $taskerId,
            ]);
        }
    }
}
