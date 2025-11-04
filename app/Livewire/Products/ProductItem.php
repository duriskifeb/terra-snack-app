<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Log;

#[Layout('components.layouts.customer')] 
class ProductItem extends Component
{
    public Product $product;

    public function mount()
    {
        $this->product->loadMissing('customizationOptions');
    }

    public function addToCart()
    {
        $user = User::find(1);
        if (!$user) {
            abort(500, 'Test user not found.');
        }
        // $user = Auth::user();
        // if (!$user) {
        //     return redirect()->route('login');
        // }

        try {
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

            $cartItem = $cart->items()
                ->where('product_id', $this->product->id)
                ->whereDoesntHave('optionValues')
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
                $newSubtotal = $cartItem->quantity * $cartItem->unit_price;
                $cartItem->update(['subtotal' => $newSubtotal]);

            } else {
                $cart->items()->create([
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'unit_price' => $this->product->price,
                    'subtotal' => $this->product->price,
                ]);
            }

            $this->dispatch('productAdded', 'Barang ditambahkan ke keranjang!');

        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menambahkan barang.');
        }
    }
    public function render()
    {
        return view('livewire.products.product-item');
    }
}
