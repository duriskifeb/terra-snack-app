<?php

namespace App\Livewire\Products;

use App\Models\OptionValue;
use App\Models\Product;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Log;

#[Layout('components.layouts.customer')] 
class ProductCustomize extends Component
{
    public Product $product;
    public $customizationGroups;
    public array $selectedOptions = [];

    public int $quantity = 1;
    public string $notes = '';
    public float $currentTotalPrice = 0.0;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->product->load('customizationOptions.optionValues');
        
        $this->customizationGroups = $this->product->customizationOptions;

        foreach ($this->customizationGroups as $group) {
            $this->selectedOptions[$group->id] = [];
        }
        
        $this->calculatePrice();
    }

      public function updatedSelectedOptions()
    {
        $this->calculatePrice();
    }

    public function updatedQuantity()
    {
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        $basePrice = $this->product->price;
        $optionsPrice = 0;

        $allSelectedIds = [];
        foreach ($this->selectedOptions as $groupId => $optionIds) {
            if (is_array($optionIds)) {
                $allSelectedIds = array_merge($allSelectedIds, $optionIds);
            } elseif (!is_null($optionIds)) {
                $allSelectedIds[] = $optionIds;
            }
        }
        
        if (!empty($allSelectedIds)) {
            $optionsPrice = OptionValue::whereIn('id', $allSelectedIds)->sum('price_modifier');
        }

        $this->currentTotalPrice = ($basePrice + $optionsPrice) * $this->quantity;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
        $this->calculatePrice();
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->calculatePrice();
        }
    }

    public function addToCart()
    {
        $user = User::find(1); 
        if (!$user) {
            abort(500, 'Test user not found.');
        }
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        $selectedOptionIds = [];
         foreach ($this->selectedOptions as $groupId => $optionIds) {
            if (is_array($optionIds)) {
                $selectedOptionIds = array_merge($selectedOptionIds, $optionIds);
            } elseif (!is_null($optionIds)) {
                $selectedOptionIds[] = $optionIds;
            }
        }
        sort($selectedOptionIds);

        $optionsPrice = OptionValue::whereIn('id', $selectedOptionIds)->sum('price_modifier');
        $unitPrice = $this->product->price + $optionsPrice;
        $subtotal = $unitPrice * $this->quantity;

        $existingItem = $cart->items()
            ->where('product_id', $this->product->id)
            ->with('optionValues:id') 
            ->get()
            ->first(function ($item) use ($selectedOptionIds) {
                $itemOptionIds = $item->optionValues->pluck('id')->all();
                sort($itemOptionIds);
                return $itemOptionIds === $selectedOptionIds;
            });

        try {
            if ($existingItem) {
                $existingItem->increment('quantity', $this->quantity);
                $newSubtotal = $existingItem->quantity * $unitPrice;
                $existingItem->update(['subtotal' => $newSubtotal]);

            } else {
                $newItem = $cart->items()->create([
                    'product_id' => $this->product->id,
                    'quantity'   => $this->quantity,
                    'unit_price' => $unitPrice,
                    'subtotal'   => $subtotal,
                ]);
                
                $newItem->optionValues()->attach($selectedOptionIds);
            }
            
            return redirect()->route('cart');

        } catch (\Exception $e) {
            Log::error('Error adding custom item to cart: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menambahkan barang.');
        }
    }

    public function render()
    {
        return view('livewire.products.product-customize');
    }
}
