<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class BidTableSeeder extends Seeder
{
    public function run(): void
    {
        $taskerIds = User::query()
            ->where('role', 'tasker')
            ->pluck('id');

        Task::query()->each(function (Task $task) use ($taskerIds) {
            $selectedTaskers = $taskerIds->shuffle()->take(rand(2, min(4, $taskerIds->count())));

            foreach ($selectedTaskers as $taskerId) {
                Bid::factory()->create([
                    'task_id' => $task->id,
                    'tasker_id' => $taskerId,
                    'status' => 'pending',
                ]);
            }
        });
    }
}
