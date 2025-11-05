<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();

            $status = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderIdWithUuid = $notification->order_id;
            $fraud = $notification->fraud_status;

            $orderId = explode('-', $orderIdWithUuid)[0];
            $order = Order::find($orderId);

            if (!$order) {
                return response()->json(['message' => 'Order not found.'], 404);
            }

            $signatureKey = hash('sha512', $orderIdWithUuid . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));
            if ($notification->signature_key != $signatureKey) {
                return response()->json(['message' => 'Invalid signature.'], 403);
            }

            if ($status == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->payment_status = 'pending_payment';
                    } else {
                        $order->payment_status = 'paid';
                        $order->status = 'processing';
                    }
                }
            } elseif ($status == 'settlement') {
                $order->payment_status = 'paid';
                $order->status = 'processing';
            } elseif ($status == 'pending') {
                $order->payment_status = 'pending_payment';

            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                $order->payment_status = 'failed';
                $order->status = 'cancelled';
            }

            $order->payment_method = $type;
            $order->save();

            return response()->json(['message' => 'Webhook handled successfully.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error handling webhook: ' . $e->getMessage()], 500);
        }
    }
}