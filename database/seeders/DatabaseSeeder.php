<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// database/seeders/DatabaseSeeder.php YANG SUDAH KOREK

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoryProductSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ]
        );

        $this->call([
            ReportSeeder::class, 
            OrderSeeder::class, 
        ]);
    }
}