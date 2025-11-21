<?php

namespace Database\Seeders;

use App\Models\CustomizationOption;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomizationOptionSeeder extends Seeder
{
    public function run(): void
    {
        $customizationData = [
            ['name' => 'Tomato', 'type' => 'sayur', 'price' => 0, 'image' => 'images/custom/sayur/tomato.png'],
            ['name' => 'Timun', 'type' => 'sayur', 'price' => 0, 'image' => 'images/custom/sayur/timun.png'],
            ['name' => 'Sawi', 'type' => 'sayur', 'price' => 0, 'image' => 'images/custom/sayur/sawi.png'],

            ['name' => 'Mix Beef', 'type' => 'topping', 'price' => 0, 'image' => 'images/custom/topping/mix-beef.png'],
            ['name' => 'Mix Chicken', 'type' => 'topping', 'price' => 0, 'image' => 'images/custom/topping/mix-chicken.png'],
            ['name' => 'Mix Beef & Chicken', 'type' => 'topping', 'price' => 0, 'image' => 'images/custom/topping/mix-beef-chicken.png'],

            ['name' => 'Tar-Tar', 'type' => 'saus', 'price' => 0, 'image' => 'images/custom/saus/tar-tar.png'],
            ['name' => 'Marinara', 'type' => 'saus', 'price' => 0, 'image' => 'images/custom/saus/marinara.png'],
            ['name' => 'Cheese', 'type' => 'saus', 'price' => 0, 'image' => 'images/custom/saus/cheese.png'],
            ['name' => 'Mixed', 'type' => 'saus', 'price' => 0, 'image' => 'images/custom/saus/mixed.png'],
        ];

        $this->seedCustomization($customizationData);

        $this->command->info('✅ Customization Options seeded successfully!');
    }

    private function seedCustomization(array $data): void
    {
        $order = 1;

        foreach ($data as $item) {
            CustomizationOption::firstOrCreate(
                [
                    'name' => $item['name'],
                    'type' => $item['type'],
                ],
                [
                    'slug' => Str::slug($item['name']),
                    'order' => $order++,
                    'is_required' => false, 
                    'multiple_selection' => false, 
                ]
            );

            $this->command->info(" > Seeded: {$item['name']} ({$item['type']})");
        }
    }
}
