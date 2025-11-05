<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Services\MidtransService; 
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Log; 


#[Layout('components.layouts.customer')]
class CheckoutPage extends Component
{
    public ?Cart $cart = null;
    public $total = 0;
    public $packagingFeeTotal = 0;

    public ?string $snapToken = null;
    public ?Order $order = null;

    public function mount()
    {
        // 1. Load the cart data (using test user)
        $user = User::find(1); // Using test user
        if (!$user) {
            abort(404, 'Test user not found.');
        }
        $this->cart = $user->cart()->with(['items.product', 'items.optionValues'])->first();

        if (!$this->cart || $this->cart->items->isEmpty()) {
            return redirect()->route('products.list');
        }

        $itemCount = $this->cart->items->sum('quantity');
        $packagingFeePerItem = 1000; 
        $this->packagingFeeTotal = $itemCount * $packagingFeePerItem;
        $this->total = $this->cart->items->sum('subtotal') + $this->packagingFeeTotal;

        $this->createOrder();
    }

    public function createOrder()
    {
        $user = User::find(1); 

        $this->order = Order::create([
            'user_id' => $user->id,
            'packaging_fee_per_item' => 1000,
            'packaging_fee_total' => $this->packagingFeeTotal,
            'total_price' => $this->total,
            'status' => 'pending', 
            'payment_status' => 'unpaid', 
            'gross_amount' => $this->total,
        ]);

        foreach ($this->cart->items as $cartItem) {
            $orderItem = $this->order->items()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'subtotal' => $cartItem->subtotal,
            ]);

            $orderItem->optionValues()->attach($cartItem->optionValues->pluck('id'));
        }

        $this->cart->items()->delete();
        $this->cart->delete();
    }

    public function generateSnapToken(MidtransService $midtransService) 
    {
        if (!$this->order) {
            $this->dispatch('show-error', 'Gagal memuat pesanan.');
            return;
        }

        try {
            $response = $midtransService->createSnapToken($this->order);
            
            $this->snapToken = $response['token'];
            
            $this->order->update([
                'gateway_ref' => $response['gateway_ref'],
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}