<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Log;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.customer')] 
class CartItem extends Component
{
    public CartItem $cartItem;

    public int $quantity;

    public function mount(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;
        $this->quantity = $cartItem->quantity;
    }

    public function updateQuantity()
    {
        $this->validate(['quantity' => 'required|integer|min:1']);
        try {
            $basePrice = $this->item->unit_price;
            $optionsPrice = $this->item->optionValues->sum('price_modifier');
            $newSubtotal = ($basePrice + $optionsPrice) * $this->quantity;
            $this->item->update([
                'quantity' => $this->quantity,
                'subtotal' => $newSubtotal,
            ]);
            $this->dispatch('cartUpdated');
        } catch (\Exception $e) {
            Log::error('Error updating cart item quantity: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal memperbarui jumlah barang.');
        }
    }

    public function incrementQuantity()
    {
        $this->quantity++;
        $this->updateQuantity();
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateQuantity();
        }
    }

    public function removeItem()
    {
        try {
            $this->item->delete();
            $this->dispatch('cartUpdated');
            $this->dispatch('show-success', 'Barang dihapus dari keranjang.');

        } catch (\Exception $e) {
            Log::error('Error removing cart item: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menghapus barang.');
        }
    }

    public function render()
    {
        $this->item->loadMissing(['product', 'optionValues']);
        return view('livewire.cart.cart-item');
    }
}
