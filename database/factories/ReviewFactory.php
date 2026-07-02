<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $task = Task::query()->whereNotNull('tasker_id')->inRandomOrder()->first() ?? Task::factory()->create();
        $type = $this->faker->randomElement(['customer_to_tasker', 'tasker_to_customer']);

        return [
            'task_id' => $task->id,
            'reviewer_id' => $type === 'customer_to_tasker' ? $task->customer_id : $task->tasker_id,
            'reviewee_id' => $type === 'customer_to_tasker' ? $task->tasker_id : $task->customer_id,
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->sentence(12),
            'type' => $type,
        ];
    }
}
