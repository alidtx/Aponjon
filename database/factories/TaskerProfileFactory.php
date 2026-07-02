<?php

namespace Database\Factories;

use App\Models\TaskerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskerProfileFactory extends Factory
{
    protected $model = TaskerProfile::class;

    public function definition(): array
    {
        $tasker = User::query()->where('role', 'tasker')->inRandomOrder()->first() ?? User::factory()->tasker()->create();

        return [
            'user_id' => $tasker->id,
            'district_id' => $tasker->district_id,
            'zila_id' => $tasker->zila_id,
            'upozila_id' => $tasker->upozila_id,
            'bio' => $this->faker->paragraph(),
            'designation' => $this->faker->randomElement(['Electrician', 'Cleaner', 'Plumber', 'Painter', 'Mover']),
            'skill' => $this->faker->randomElements(['Electrical', 'Cleaning', 'Plumbing', 'Painting', 'Moving', 'Handyman'], rand(2, 4)),
            'hourly_rate' => $this->faker->randomFloat(2, 200, 2500),
            'nid_number' => $this->faker->numerify('##########'),
            'experience' => [
                'years' => $this->faker->numberBetween(1, 12),
                'completed_projects' => $this->faker->numberBetween(5, 150),
            ],
            'verification_status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'rating' => $this->faker->randomFloat(2, 3, 5),
            'completed_task' => $this->faker->numberBetween(0, 100),
            'is_online' => $this->faker->boolean(),
        ];
    }
}
