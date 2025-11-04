<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\User;
use Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.customer')] 
class CartPage extends Component
{
    public Cart $cart;

    protected $listeners = ['cartUpdated' => 'refreshCart'];
    public $subtotal = 0;
    public $packagingFeeTotal = 0;
    public $total = 0;

    public function mount()
    {
        $user = User::find(1);
        if (!$user) {
            abort(404, 'Test user (ID 1) not found. Please run tinker to create User ID 1 and its cart.');
        }
        $this->cart = $user->cart()->firstOrCreate(
            ['user_id' => $user->id]
        );

        // $this->cart = Auth::user()->cart()->with(['items.product', 'items.optionValues'])->firstOrFail();
        $this->loadCartDetails();
        $this->calculateTotals();
    }

    public function refreshCart()
    {
        $this->loadCartDetails();
        $this->calculateTotals();
    }

    public function loadCartDetails()
    {
        if ($this->cart) {
            $this->cart->load(['items.product', 'items.optionValues']);
        }
    }
    public function calculateTotals()
    {
        if (!$this->cart || !$this->cart->relationLoaded('items')) {
            $this->subtotal = 0;
            $this->packagingFeeTotal = 0;
            $this->total = 0;
            return;
        }

        $this->subtotal = $this->cart->items->sum('subtotal');

        $itemCount = $this->cart->items->sum('quantity');
        $packagingFeePerItem = 1000;

        $this->packagingFeeTotal = $itemCount * $packagingFeePerItem;
        $this->total = $this->subtotal + $this->packagingFeeTotal;
    }

    public function render()
    {
        return view('livewire.cart.cart-page')
            ->layout('components.layouts.customer');
    }
}
