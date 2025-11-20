<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $user = User::where('email', 'admin@mail.com')->first();

        if ($products->isEmpty() || !$user) {
            $this->command->error('❌ Tidak dapat membuat laporan: Produk atau User tidak ditemukan.');
            return;
        }

        $reportsCount = 30; 

        for ($i = 0; $i < $reportsCount; $i++) {
            $randomDays = rand(1, 60);
            $randomDate = Carbon::now()->subDays($randomDays);

            $randomProduct = $products->random();
            $amount = $randomProduct->price * rand(1, 3);

            Report::create([
                'title' => 'Laporan Penjualan #' . ($i + 1) . ' - ' . $randomProduct->name,
                'name' => 'Penjualan Otomatis Harian', 
                'type' => 'Penjualan', 
                'start_date' => $randomDate, 
                'end_date' => $randomDate, 
                
                'generated_by' => $user->id, 
                'product_id' => $randomProduct->id, 
                'amount' => $amount, 
                'status' => ['Success', 'Pending', 'Failed'][array_rand(['Success', 'Pending', 'Failed'])],
                
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }

        $this->command->info('✅ Sample reports seeded successfully!');
        $this->command->info('📊 Total reports: ' . Report::count());
    }
}