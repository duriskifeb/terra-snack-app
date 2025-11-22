<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoryProductSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            CustomizationOptionSeeder::class, 
        ]);

        // User Admin
        User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('aDmin567;'),
                'role' => 'admin',
                'phone' => '08123456789',
            ]
        );

        // User Stand 
        User::firstOrCreate(
            ['email' => 'stand@mail.com'],
            [
                'name' => 'Stand Operator',
                'password' => bcrypt('stanD567;'),
                'role' => 'stand_staff',
                'phone' => '08129876543',
            ]
        );

        $this->call([
            ReportSeeder::class,
            OrderSeeder::class,
        ]);

        $this->command->info('✅ All users (admin & stand) created successfully!');
    }
}