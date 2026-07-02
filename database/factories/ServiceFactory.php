<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'description' => $this->faker->paragraph(3),
            'base_price' => $this->faker->randomFloat(2, 500, 15000),
            'duration_unit' => $this->faker->randomElement(['hour', 'day', 'task']),
            'estimated_duration' => $this->faker->numberBetween(1, 10),
            'requirements' => [
                'materials' => $this->faker->randomElements(['Tools', 'Cleaning supplies', 'Vehicle access', 'Spare parts'], 2),
                'notes' => $this->faker->sentence(),
            ],
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
