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
        $district = District::factory()->create();
        $zila = Zila::factory()->create(['district_id' => $district->id]);
        $upozila = Upozila::factory()->create(['zila_id' => $zila->id]);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'password' => bcrypt('password'),
            'role' => $this->getWeightedUserRole(), 
            'avatar' => fake()->optional(0.7)->imageUrl(100, 100, 'people'),
            'is_verified' => fake()->boolean(80),
            'district_id' => $district->id,
            'zila_id' => $zila->id,
            'upozila_id' => $upozila->id,
            'remember_token' => Str::random(10),
        ];
    }

     private function getWeightedUserRole(): string
    {
        
        $roles = [
            'customer' => 47, 
            'tasker'   => 47, 
            'admin'    => 6,  
        ];

        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($roles as $role => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $role;
            }
        }

        return 'customer';
    }

}
