<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(), // Links or creates a Task
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'platform_fee' => $this->faker->randomFloat(2, 5, 100),
            'tasker_earning' => $this->faker->randomFloat(2, 40, 900),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => $this->faker->randomElement(['SLL', 'bkash']),
            'transaction_id' => strtoupper($this->faker->bothify('TXN-#####-????')),
        ];
    }
}
