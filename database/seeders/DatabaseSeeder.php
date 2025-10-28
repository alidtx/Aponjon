<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
         $this->call([
            DistrictsTableSeeder::class,
            ZilasTableSeeder::class,
            UpozilasTableSeeder::class,
            UsersTableSeeder::class,
            TaskerProfileTableSeeder::class,
            CategoryTableSeeder::class,
            ServiceTableSeeder::class,
            TaskTableSeeder::class,
            BidTableSeeder::class,
            OrderTableSeeder::class,
            ReviewTableSeeder::class,
            PermissionTableSeeder::class
        ]);
    }
}
