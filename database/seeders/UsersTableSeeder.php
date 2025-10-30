<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    
    public function run(): void
    {  
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+8801000000001',
            'role' => 'admin',
            'is_verified' => true,
        ]);
           
        User::factory()->count(10)->create();
    }
}
