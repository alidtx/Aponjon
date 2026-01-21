<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\District;
use App\Models\Task;
use App\Models\User;
use App\Models\Service;
use App\Models\Zila;
use App\Models\Upozila;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {   
        $title = $this->faker->sentence();
        return [
            'task_number' => strtoupper(Str::random(10)), 
            'customer_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'tasker_id' => User::inRandomOrder()->first()?->id, 
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'description' => $this->faker->paragraph(),
            'location_address' => $this->faker->address(),
            'location_coordinates' => $this->faker->latitude() . ',' . $this->faker->longitude(), 
            'district_id' => District::inRandomOrder()->first()?->id ?? District::factory(),
            'zila_id' => Zila::inRandomOrder()->first()?->id ?? District::factory(),
            'upozila_id' => Upozila::inRandomOrder()->first()?->id ?? Zila::factory(),
            'emergency' => $this->faker->randomElement(['normal', 'urgent','emergency','other']),
            'budget' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['posted', 'assigned', 'in_progress', 'completed', 'cancelled', 'disputed']),
            'customer_notes' => $this->faker->optional()->sentence(),
        ];
    }
}
