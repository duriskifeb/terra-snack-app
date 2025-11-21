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

        User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'phone' => '08123456789',
            ]
        );

        $this->call([
            ReportSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
