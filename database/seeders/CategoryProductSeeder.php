<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['slug' => 'snack'],
            ['name' => 'Snack']
        );

        Category::firstOrCreate(
            ['slug' => 'minuman'],
            ['name' => 'Minuman']
        );
        
        $this->command->info('✅ Categories (Snack, Minuman) seeded successfully!');
    }
}