<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.customer')]
class CheckoutPage extends Component
{
    use WithFileUploads;

    public $cart;
    public ?Order $order = null;
    public $totalPrice = 0;
    public $subtotal = 0;
    public $packagingFeeTotal = 0;

    public $paymentProof;

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $this->cart = $user->cart()->with('items.product', 'items.optionValues')->first();

        if (!$this->cart || $this->cart->items->isEmpty()) {
            $this->dispatch('show-error', 'Keranjang Anda kosong.');
            return $this->redirect(route('products.list'));
        }

        $this->subtotal = $this->cart->items->sum('subtotal');
        $itemCount = $this->cart->items->sum('quantity');
        $packagingFeePerItem = 1000;
        $this->packagingFeeTotal = $itemCount * $packagingFeePerItem;
        $this->totalPrice = $this->subtotal + $this->packagingFeeTotal;

        $this->order = Order::where('user_id', $user->id)
            ->where('payment_status', 'unpaid')
            ->with(['items.optionValues.customizationOption'])
            ->first();

        if (!$this->order) {
            DB::transaction(function () use ($user) {
                $newOrder = Order::create([
                    'user_id' => $user->id,
                    'packaging_fee_total' => $this->packagingFeeTotal,
                    'total_price' => $this->totalPrice,
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    'payment_method' => 'QRIS Statis',
                ]);

                foreach ($this->cart->items as $item) {
                    $orderItem = $newOrder->items()->create([
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'subtotal' => $item->subtotal,
                    ]);

                    $orderItem->optionValues()->attach($item->optionValues->pluck('id'));
                }

                $this->order = $newOrder->fresh([
                    'items',
                    'items.product',
                    'items.optionValues',
                    'items.optionValues.customizationOption'
                ]);


                $this->cart->items()->delete();
                $this->cart->refresh();
            });
        }
    }

    public function uploadPaymentProof()
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048',
        ]);

        $path = $this->paymentProof->store('payment_proofs', 'public');


        $this->order->update([
            'payment_proof' => $path,
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        $this->dispatch('show-success', 'Bukti pembayaran berhasil di-upload. Silakan tunggu konfirmasi.');
        $this->order->refresh();
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}