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

#[Layout('components.layouts.customer')]
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
        $user = User::find(1);
        if (!$user) {
            abort(404, 'User tidak ditemukan.');
        }

        $this->cart = $user->cart()->with('items.product')->first();

        if (!$this->cart || $this->cart->items->isEmpty()) {
            $this->dispatch('show-error', 'Keranjang Anda kosong.');
            return $this->redirect(route('products.list'));
        }

        $this->subtotal = $this->cart->items->sum('subtotal');
        $itemCount = $this->cart->items->sum('quantity');
        $packagingFeePerItem = 1000;
        $this->packagingFeeTotal = $itemCount * $packagingFeePerItem;


        $this->totalPrice = $this->subtotal + $this->packagingFeeTotal;

        $existingOrder = Order::where('user_id', $user->id)
            ->where('payment_status', 'unpaid')
            ->first();

        if ($existingOrder) {
            $this->order = $existingOrder;
        } else {
            DB::transaction(function () use ($user) {
                $this->order = Order::create([
                    'user_id' => $user->id,
                    'packaging_fee_total' => $this->packagingFeeTotal,
                    'total_price' => $this->totalPrice,
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    'payment_method' => 'QRIS Statis',
                ]);

                foreach ($this->cart->items as $item) {
                    $this->order->items()->create([
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'subtotal' => $item->subtotal,
                    ]);

                    $item->load('optionValues');
                    $newItem = $this->order->items()->latest()->first();
                    $newItem->optionValues()->attach($item->optionValues->pluck('id'));
                }

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

        $this->cart->items()->delete();
        $this->cart->refresh();

        $this->dispatch('show-success', 'Bukti pembayaran berhasil di-upload. Silakan tunggu konfirmasi.');
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
