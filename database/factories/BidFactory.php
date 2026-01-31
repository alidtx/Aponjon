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
    public function definition(): array
    {
        $availability = $this->faker->randomElement(['today', 'tomorrow', 'specific']);

        return [
            'task_id' => Task::factory(),
            'tasker_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 100000),
            'proposal' => $this->faker->paragraph(),
            'estimated_hours' => $this->faker->numberBetween(1, 40),
            'availability' => $availability,
            'specific_date' => $availability === 'specific'
                ? $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d')
                : null,
            'terms_accepted' => true,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
