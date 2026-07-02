<?php

namespace Database\Factories;

use App\Models\Bid;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidFactory extends Factory
{
    protected $model = Bid::class;

    public function definition(): array
    {
        $availability = $this->faker->randomElement(['today', 'tomorrow', 'specific']);
        $task = Task::query()->inRandomOrder()->first() ?? Task::factory()->create();
        $tasker = User::query()->where('role', 'tasker')->inRandomOrder()->first() ?? User::factory()->tasker()->create();

        return [
            'task_id' => $task->id,
            'tasker_id' => $tasker->id,
            'amount' => $this->faker->randomFloat(2, 500, 20000),
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
