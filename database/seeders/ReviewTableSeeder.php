<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Task;
use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
    public function run(): void
    {
        $completedTasks = Task::query()
            ->where('status', 'completed')
            ->whereNotNull('tasker_id')
            ->get();

        foreach ($completedTasks as $task) {
            Review::query()->create([
                'task_id' => $task->id,
                'reviewer_id' => $task->customer_id,
                'reviewee_id' => $task->tasker_id,
                'rating' => rand(4, 5),
                'comment' => fake()->sentence(10),
                'type' => 'customer_to_tasker',
            ]);

            Review::query()->create([
                'task_id' => $task->id,
                'reviewer_id' => $task->tasker_id,
                'reviewee_id' => $task->customer_id,
                'rating' => rand(4, 5),
                'comment' => fake()->sentence(10),
                'type' => 'tasker_to_customer',
            ]);
        }
    }
}
