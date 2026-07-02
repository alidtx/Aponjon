<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $customer = User::query()->where('role', 'customer')->inRandomOrder()->first() ?? User::factory()->customer()->create();
        $title = $this->faker->sentence();

        return [
            'task_number' => 'TSK-' . strtoupper(Str::random(8)),
            'customer_id' => $customer->id,
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'tasker_id' => null,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(6)),
            'description' => $this->faker->paragraphs(2, true),
            'location_address' => $this->faker->address(),
            'location_coordinates' => $this->faker->latitude() . ',' . $this->faker->longitude(),
            'district_id' => $customer->district_id,
            'zila_id' => $customer->zila_id,
            'upozila_id' => $customer->upozila_id,
            'emergency' => $this->faker->randomElement(['normal', 'urgent', 'emergency', 'other']),
            'budget' => $this->faker->randomFloat(2, 800, 25000),
            'status' => 'posted',
            'customer_notes' => $this->faker->optional()->sentence(),
            'bidding_ends_at' => now()->addDays(rand(1, 7)),
        ];
    }
}
