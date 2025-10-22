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
        return [
            'user_id' => User::factory(), 
            'bio' => $this->faker->paragraph,
            'skill' => $this->faker->randomElements(['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'MySQL'], rand(1, 3)),
            'daily_rate' => $this->faker->randomFloat(2, 10, 500), 
            'document' => [
                'id_card' => $this->faker->uuid . '.jpg',
                'certificate' => $this->faker->uuid . '.pdf',
            ],
            'verification_status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'rating' => $this->faker->randomFloat(2, 0, 5),
            'completed_task' => $this->faker->numberBetween(0, 100),
            'is_online' => $this->faker->boolean,
        ];
    }
}
