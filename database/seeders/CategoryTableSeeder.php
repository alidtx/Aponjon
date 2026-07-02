<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Home Cleaning', 'description' => 'Routine, deep, and move-in cleaning services.'],
            ['name' => 'Plumbing', 'description' => 'Leak fixes, pipe work, and bathroom maintenance.'],
            ['name' => 'Electrical', 'description' => 'Wiring, fan setup, lights, and appliance repair.'],
            ['name' => 'Moving Help', 'description' => 'Packing, shifting, and unloading support.'],
            ['name' => 'Painting', 'description' => 'Interior and exterior paint jobs for homes and offices.'],
            ['name' => 'AC Repair', 'description' => 'Cooling diagnostics, servicing, and installation help.'],
            ['name' => 'Appliance Repair', 'description' => 'Repair support for kitchen and home appliances.'],
            ['name' => 'Handyman', 'description' => 'General home fixes, drilling, mounting, and odd jobs.'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
