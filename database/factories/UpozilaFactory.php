<?php

namespace Database\Factories;

use App\Models\Zila;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UpozilaFactory extends Factory
{
    public function definition(): array
    {
        static $i = 1;

        $name = 'Upozila ' . $i++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'zila_id' => Zila::inRandomOrder()->first()->id ?? Zila::factory(),
        ];
    }
}
