<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '082139102459'
        ]);

        User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('aDmin567;'),
                'role' => 'admin',
                'phone' => '08123456789',
            ]
        );

        User::firstOrCreate(
            ['email' => 'stand@mail.com'],
            [
                'name' => 'Stand',
                'password' => bcrypt('stanD567;'),
                'role' => 'stand_staff',
                'phone' => '0897654321',
            ]
        );

        $this->call([
            ReportSeeder::class,
            OrderSeeder::class,
        ]);

        $this->command->info('✅ All users (admin & stand) created successfully!');
    }
}