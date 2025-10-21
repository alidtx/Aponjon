<?php

namespace Database\Factories;

use App\Models\Upozila;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Upozila>
 */
class UpozilaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $name=fake()->unique()->word();
        return [
            'name'=>ucfirst($name),
            'slug'=>str::slug($name),
            'zila_id'=>Upozila::factory()  
        ];
    }
}
