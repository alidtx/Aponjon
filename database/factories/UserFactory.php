<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\District;
use App\Models\Zila;
use App\Models\Upozila;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        // Create related records using factories
        $district = District::factory()->create();
        $zila = Zila::factory()->create(['district_id' => $district->id]);
        $upozila = Upozila::factory()->create(['zila_id' => $zila->id]);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'password' => bcrypt('password'),
            'type' => $this->getWeightedUserType(),
            'avatar' => fake()->optional(0.7)->imageUrl(100, 100, 'people'),
            'is_verified' => fake()->boolean(80),
            'district_id' => $district->id,
            'zila_id' => $zila->id,
            'upozila_id' => $upozila->id,
            'remember_token' => Str::random(10),
            'email_verified_at' => fake()->optional(0.8)->dateTime(),
        ];
    }
}