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
            'Sayur' => [
                'type' => 'single',
                'values' => [
                    ['name' => 'Tomato', 'price' => 0, 'image' => 'images/custom/sayur/tomato.png'],
                    ['name' => 'Timun', 'price' => 0, 'image' => 'images/custom/sayur/timun.png'],
                    ['name' => 'Sawi', 'price' => 0, 'image' => 'images/custom/sayur/sawi.png'],
                ],
            ],
            'Topping' => [
                'type' => 'single',
                'values' => [
                    ['name' => 'Mix Beef', 'price' => 0, 'image' => 'images/custom/topping/mix-beef.png'],
                    ['name' => 'Mix Chicken', 'price' => 0, 'image' => 'images/custom/topping/mix-chicken.png'],
                    ['name' => 'Mix Beef & Chicken', 'price' => 0, 'image' => 'images/custom/topping/mix-beef-chicken.png'],
                ],
            ],
            'Saus' => [
                'type' => 'single',
                'values' => [
                    ['name' => 'Tar-Tar', 'price' => 0, 'image' => 'images/custom/saus/tar-tar.png'],
                    ['name' => 'Marinara', 'price' => 0, 'image' => 'images/custom/saus/marinara.png'],
                    ['name' => 'Cheese', 'price' => 0, 'image' => 'images/custom/saus/cheese.png'],
                    ['name' => 'Mixed', 'price' => 0, 'image' => 'images/custom/saus/mixed.png'],
                ],
            ],
        ];

        $this->seedCustomization($customizationData);

        $this->command->info('✅ Customization Options & Values seeded successfully!');
    }

    private function seedCustomization(array $data): void
    {
        $order = 1;

        foreach ($data as $optionName => $optionData) {

            $option = CustomizationOption::firstOrCreate(
                ['name' => $optionName],
                [
                    'slug' => Str::slug($optionName),
                    'type' => $optionData['type'],
                    'order' => $order++,
                    'is_required' => true,
                    'multiple_selection' => $optionData['type'] === 'multiple'
                ]
            );

            $this->command->info(" > Seeding values for: {$optionName}");

            foreach ($optionData['values'] as $value) {
                OptionValue::firstOrCreate(
                    [
                        'customization_option_id' => $option->id,
                        'name' => $value['name'],
                    ],
                    [
                        'slug' => Str::slug($value['name']),
                        'price' => $value['price'],
                        'image_url' => $value['image'],
                    ]
                );
            }
        }
    }
}
