<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@tasker.com',
            'phone' => '+8801000000001',
            'type' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);
           
        User::factory()->count(10)->create();
    }
}
