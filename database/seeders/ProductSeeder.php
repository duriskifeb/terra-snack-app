<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::first();

        $productsData = [
            ['name' => 'Laptop Gaming A', 'price' => 15000000, 'description' => 'Laptop kencang untuk gaming.'],
            ['name' => 'Smartphone Pro X', 'price' => 7500000, 'description' => 'Smartphone flagship terbaru.'],
            ['name' => 'Headset Bluetooth Z', 'price' => 850000, 'description' => 'Headset dengan noise cancelling.'],
            ['name' => 'Mouse Wireless E', 'price' => 250000, 'description' => 'Mouse ergonomis dan presisi.'],
            ['name' => 'Monitor 4K Curved', 'price' => 4500000, 'description' => 'Monitor resolusi tinggi untuk desain.'],
        ];

        foreach ($productsData as $data) {
            Product::firstOrCreate(
                ['name' => $data['name']],
                [
                    'category_id' => $category ? $category->id : null, 
                    'slug' => Str::slug($data['name']),
                    'price' => $data['price'],
                    'description' => $data['description'],
                    'image_url' => null
                ]
            );
        }

        $this->command->info('✅ Sample products seeded successfully!');
    }
}