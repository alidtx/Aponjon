<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(), // Creates or links a Task
            'tasker_id' => User::factory(), // Creates or links a User
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'proposal' => $this->faker->paragraph(),
            'estimated_hours' => $this->faker->numberBetween(1, 40),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
