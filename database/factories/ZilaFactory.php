<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\District;

class ZilaFactory extends Factory
{
    
    public function definition(): array
    {
       
        static $i = 1;

        $name = 'Zila ' . $i++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'district_id' => District::inRandomOrder()->first()->id ?? District::factory(),
        ];
    }
}
