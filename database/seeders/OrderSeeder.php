<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();
        
        $paymentMethods = ['QRIS', 'Transfer Bank', 'Kartu Debit'];

        $paymentStatuses = ['paid', 'unpaid', 'pending_verification', 'expired']; 
        $orderStatuses = ['completed', 'processing', 'cancelled', 'pending'];
        
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->error('❌ Gagal: Data dasar (User, Product) tidak lengkap.');
            return;
        }

        $ordersCount = 20;
        
        for ($i = 0; $i < $ordersCount; $i++) {
            $randomDays = rand(1, 90);
            $orderDate = Carbon::now()->subDays($randomDays);
            $grossAmount = 0; 
            $packagingFeePerItem = 2500;
            $totalItems = 0;
            $itemsCount = rand(1, 3);
            $orderedProducts = $products->random($itemsCount); 

            foreach ($orderedProducts as $product) {
                $quantity = rand(1, 5);
                $grossAmount += $product->price * $quantity;
                $totalItems += $quantity;
            }

            $packagingFeeTotal = $packagingFeePerItem * $totalItems;
            $totalPrice = $grossAmount + $packagingFeeTotal; 
            
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            $paidAt = ($paymentStatus === 'paid') ? $orderDate->copy()->addMinutes(rand(5, 60)) : null;

            $order = Order::create([
                'user_id' => $users->random()->id,
                'packaging_fee_per_item' => $packagingFeePerItem,
                'packaging_fee_total' => $packagingFeeTotal,
                'total_price' => $totalPrice, 
                'status' => $orderStatuses[array_rand($orderStatuses)],
                'gross_amount' => $grossAmount,
                'payment_status' => $paymentStatus, 
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'paid_at' => $paidAt, 
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            foreach ($orderedProducts as $product) {
                $quantity = rand(1, 5);
                $unitPrice = $product->price;
                $subtotal = $unitPrice * $quantity;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }
        }

        $this->command->info('✅ Sample orders seeded successfully!');
        $this->command->info('📊 Total orders created: ' . Order::count());
    }
}