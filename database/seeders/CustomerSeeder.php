<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            ],
            [
                'name' => 'Sari Indah',
                'email' => 'sari.indah@email.com', 
                'phone' => '081298765432',
                'address' => 'Jl. Sudirman Kav. 25, Jakarta Selatan',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@email.com',
                'phone' => '081112223344',
                'address' => 'Komplek Permata Hijau Blok A1 No. 5, Jakarta Barat',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'phone' => '081334455667',
                'address' => 'Jl. Gatot Subroto No. 78, Jakarta Selatan',
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki.pratama@email.com',
                'phone' => '081556677889',
                'address' => 'Apartemen Taman Anggrek, Lt. 15 No. 1501, Jakarta Barat',
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@email.com',
                'phone' => '081778899001',
                'address' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@email.com',
                'phone' => '081990011223',
                'address' => 'Perumahan Pondok Indah Blok C No. 12, Jakarta Selatan',
            ],
            [
                'name' => 'Linda Wati',
                'email' => 'linda.wati@email.com',
                'phone' => '081223344556',
                'address' => 'Jl. Thamrin No. 10, Jakarta Pusat',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.nugroho@email.com',
                'phone' => '081445566778',
                'address' => 'Komplek Green Garden Blok D No. 8, Jakarta Utara',
            ],
            [
                'name' => 'Anita Rahayu',
                'email' => 'anita.rahayu@email.com',
                'phone' => '081667788990',
                'address' => 'Jl. Rasuna Said Kav. 15, Kuningan, Jakarta Selatan',
            ]
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }

        $this->command->info('✅ Sample customers seeded successfully!');
        $this->command->info('📊 Total customers: ' . Customer::count());
    }
}