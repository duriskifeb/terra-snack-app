<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\CustomizationOption;
use App\Models\OptionValue;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $snackCategory = Category::create([
            'name' => 'Snack',
            'slug' => Str::slug('Snack'),
        ]);

        $drinkCategory = Category::create([
            'name' => 'Minuman',
            'slug' => Str::slug('Minuman'),
        ]);

        $sizeOption = CustomizationOption::create([
            'name' => 'Size',
            'type' => 'select',
        ]);

        $toppingOption = CustomizationOption::create([
            'name' => 'Topping',
            'type' => 'checkbox',
        ]);

        $sugarOption = CustomizationOption::create([
            'name' => 'Sugar Level',
            'type' => 'radio',
        ]);

        $sizeSmall = OptionValue::create([
            'customization_option_id' => $sizeOption->id,
            'name' => 'Small',
            'details' => ['Portion' => '100g', 'Calories' => '200 kcal'],
            'price_modifier' => 0.00,
        ]);

        $sizeLarge = OptionValue::create([
            'customization_option_id' => $sizeOption->id,
            'name' => 'Large',
            'details' => ['Portion' => '200g', 'Calories' => '400 kcal'],
            'price_modifier' => 5.00,
        ]);

        $toppingChoco = OptionValue::create([
            'customization_option_id' => $toppingOption->id,
            'name' => 'Chocolate Chips',
            'details' => ['Flavor' => 'Sweet', 'Texture' => 'Crunchy'],
            'price_modifier' => 2.00,
        ]);

        $sugarNormal = OptionValue::create([
            'customization_option_id' => $sugarOption->id,
            'name' => 'Normal',
            'details' => ['Sweetness' => 'Regular'],
            'price_modifier' => 0.00,
        ]);


        $sugarLess = OptionValue::create([
            'customization_option_id' => $sugarOption->id,
            'name' => 'Less Sugar',
            'price_modifier' => 0.00,
        ]);

    
        $products = [
            [
                'category_id' => $snackCategory->id,
                'name' => 'Choco Crunch',
                'slug' => 'choco-crunch',
                'price' => 15.00,
                'description' => 'Crunchy chocolate snack.',
                'image_url' => 'https://images.pexels.com/photos/4109948/pexels-photo-4109948.jpeg',
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Cheese Ball',
                'slug' => 'cheese-ball',
                'price' => 12.00,
                'description' => 'Delicious cheese-flavored snack.',
                'image_url' => 'https://images.pexels.com/photos/1615198/pexels-photo-1615198.jpeg',
            ],
            [
                'category_id' => $drinkCategory->id,
                'name' => 'Iced Coffee',
                'slug' => 'iced-coffee',
                'price' => 20.00,
                'description' => 'Cold coffee with ice cubes.',
                'image_url' => 'https://images.pexels.com/photos/3779094/pexels-photo-3779094.jpeg',
            ],
            [
                'category_id' => $drinkCategory->id,
                'name' => 'Milk Tea',
                'slug' => 'milk-tea',
                'price' => 18.00,
                'description' => 'Sweet and creamy milk tea.',
                'image_url' => 'https://images.pexels.com/photos/4113833/pexels-photo-4113833.jpeg',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            if ($product->category_id === $drinkCategory->id) {
                $product->customizationOptions()->attach([
                    $sizeOption->id,
                    $sugarOption->id,
                    $toppingOption->id,
                    // $sizeLarge->id,
                ]);
            } else {
                $product->customizationOptions()->attach([
                    $toppingOption->id,
                ]);
            }
        }
    }
}
