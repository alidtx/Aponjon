<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $categories = Category::pluck('id')->toArray(); 

        return [
            'title' => $this->faker->unique()->sentence(3),
            'category_id' => $this->faker->randomElement($categories) ?: Category::factory(), 
            'description' => $this->faker->paragraph(3),
            'base_price' => $this->faker->randomFloat(2, 50, 1000),
            'duration_unit' => $this->faker->randomElement(['hour', 'day', 'task']),
            'estimated_duration' => $this->faker->numberBetween(1, 10),
            'requirements' => [
                'requirement_1' => $this->faker->word,
                'requirement_2' => $this->faker->word,
            ],
            'is_active' => $this->faker->boolean(90), 
        ];
    }
}
