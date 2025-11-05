<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;
use Log;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * 
     *
     * @param Order $order
     * @return array ['token' => string, 'gateway_ref' => string]
     */
    public function createSnapToken(Order $order): array
    {
        $item_details = [];
        foreach ($order->items as $item) {
            $item_details[] = [
                'id' => $item->id,
                'price' => $item->unit_price, 
                'quantity' => $item->quantity,
                'name' => $item->product_name,
            ];
        }

        if ($order->packaging_fee_total > 0) {
            $item_details[] = [
                'id' => 'PACKAGING_FEE',
                'price' => $order->packaging_fee_total,
                'quantity' => 1,
                'name' => 'Biaya Packaging',
            ];
        }
        
        $gatewayRef = $order->id . '-' . Str::uuid();

        $params = [
            'transaction_details' => [
                'order_id' => $gatewayRef,
                'gross_amount' => $order->gross_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'item_details' => $item_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            return [
                'token' => $snapToken,
                'gateway_ref' => $gatewayRef,
            ];

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            throw $e; 
        }
    }
}