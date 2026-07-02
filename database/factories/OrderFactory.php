<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 800, 25000);
        $platformFee = round($amount * 0.1, 2);

        return [
            'task_id' => Task::query()->inRandomOrder()->value('id') ?? Task::factory(),
            'amount' => $amount,
            'platform_fee' => $platformFee,
            'tasker_earning' => round($amount - $platformFee, 2),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => $this->faker->randomElement(['SSL', 'bkash']),
            'transaction_id' => strtoupper($this->faker->bothify('TXN-#####-????')),
        ];
    }
}
