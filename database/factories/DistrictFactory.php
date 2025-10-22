<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DistrictFactory extends Factory
{
    public function definition(): array
    {

        static $i = 1;

        $name = 'District ' . $i++;
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
