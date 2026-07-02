<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+8801000000001',
            'is_profile_completed' => true,
        ]);

        User::factory()->customer()->count(12)->create();
        User::factory()->tasker()->count(10)->create();
    }
}
