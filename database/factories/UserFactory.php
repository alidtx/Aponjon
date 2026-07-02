<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Upozila;
use App\Models\User;
use App\Models\Zila;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password = null;

    public function definition(): array
    {
        [$districtId, $zilaId, $upozilaId] = $this->resolveLocationIds();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('+8801#########'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['customer', 'tasker']),
            'avatar' => fake()->optional(0.6)->imageUrl(100, 100, 'people'),
            'is_verified' => fake()->boolean(80),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'is_active' => fake()->boolean(90),
            'is_profile_completed' => fake()->boolean(75),
            'district_id' => $districtId,
            'zila_id' => $zilaId,
            'upozila_id' => $upozilaId,
            'remember_token' => Str::random(10),
        ];
    }

    public function customer(): static
    {
        return $this->state(fn () => [
            'role' => 'customer',
            'status' => 'approved',
            'is_verified' => true,
            'is_active' => true,
        ]);
    }

    public function tasker(): static
    {
        return $this->state(fn () => [
            'role' => 'tasker',
            'status' => 'approved',
            'is_verified' => true,
            'is_active' => true,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => 'admin',
            'status' => 'approved',
            'is_verified' => true,
            'is_active' => true,
            'is_profile_completed' => true,
        ]);
    }

    private function resolveLocationIds(): array
    {
        $upozila = Upozila::query()->inRandomOrder()->first();

        if ($upozila) {
            $zila = Zila::query()->find($upozila->zila_id);
            $district = $zila ? District::query()->find($zila->district_id) : null;

            return [$district?->id, $zila?->id, $upozila->id];
        }

        $district = District::factory()->create();
        $zila = Zila::factory()->create(['district_id' => $district->id]);
        $upozila = Upozila::factory()->create(['zila_id' => $zila->id]);

        return [$district->id, $zila->id, $upozila->id];
    }
}
