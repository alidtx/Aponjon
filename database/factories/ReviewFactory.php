<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {  
        $type = $this->faker->randomElement(['customer_to_tasker', 'tasker_to_customer']);
        return [
            'task_id' => Task::factory(),
            'reviewer_id' => User::factory(),
            'reviewee_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(12),
            'type' => $type,
        ];
    }
}
