<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\District;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zila>
 */
class ZilaFactory extends Factory
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
             'district_id' => District::factory()

        ];
    }
}
