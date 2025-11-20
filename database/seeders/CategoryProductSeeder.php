<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $snackCategory = Category::firstOrCreate(
            ['slug' => 'snack'],
            ['name' => 'Snack']
        );

        $minumanCategory = Category::firstOrCreate(
            ['slug' => 'minuman'],
            ['name' => 'Minuman']
        );

        Product::firstOrCreate(
            ['slug' => 'air-putih'],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Air Putih',
                'price' => 5000,
                'description' => 'Air putih mineral segar'
            ]
        );

        $snackProducts = [
            [
                'name' => 'Chitato Sapi Panggang',
                'slug' => 'chitato-sapi-panggang',
                'price' => 20000,
                'description' => 'Keripik kentang rasa sapi panggang'
            ],
            [
                'name' => 'Chitato Lite',
                'slug' => 'chitato-lite',
                'price' => 20000,
                'description' => 'Chitato versi lite dengan kalori lebih rendah'
            ],
            [
                'name' => 'Chitato Lite Rumput Laut',
                'slug' => 'chitato-lite-rumput-laut',
                'price' => 20000,
                'description' => 'Chitato lite dengan rasa rumput laut'
            ],
            [
                'name' => 'Chiki Twist Jagung Bakar',
                'slug' => 'chiki-twist-jagung-bakar',
                'price' => 15000,
                'description' => 'Snack twist dengan rasa jagung bakar'
            ],
            [
                'name' => 'Happytos Jagung Bakar',
                'slug' => 'happytos-jagung-bakar',
                'price' => 18000,
                'description' => 'Snack ringan rasa jagung bakar'
            ],
            [
                'name' => 'Maxicorn Barbecue',
                'slug' => 'maxicorn-barbecue',
                'price' => 22000,
                'description' => 'Snack corn dengan rasa barbecue'
            ]
        ];

        foreach ($snackProducts as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, [
                    'category_id' => $snackCategory->id
                ])
            );
        }

        $this->command->info('Categories and products seeded successfully!');
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Products: ' . Product::count());
    }
}
