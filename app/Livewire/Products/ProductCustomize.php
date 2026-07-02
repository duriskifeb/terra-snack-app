<?php

namespace App\Livewire\Products;

use App\Models\CartItem; // <-- Added this
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\User;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url; // <-- Added this
use Livewire\Component;
use Log;

#[Layout('layouts.customer')] 
class ProductCustomize extends Component
{
    public Product $product;
    public $customizationGroups;
    public array $selectedOptions = [];

    public int $quantity = 1;
    public string $notes = ''; 
    public float $currentTotalPrice = 0.0;

    #[Url] 
    public ?int $cartItemId = null;

    public ?CartItem $cartItem = null;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->product->load('customizationOptions.optionValues');
        $this->customizationGroups = $this->product->customizationOptions;

        if ($this->cartItemId) {
            $this->cartItem = CartItem::with('optionValues')->find($this->cartItemId);
            
            if ($this->cartItem && $this->cartItem->product_id === $this->product->id) {
                $this->quantity = $this->cartItem->quantity;
                $this->notes = $this->cartItem->notes ?? '';
                
                foreach ($this->customizationGroups as $group) {
                    $selectedIdsInGroup = $this->cartItem->optionValues
                        ->where('customization_option_id', $group->id)
                        ->pluck('id')
                        ->all();

                    $key = 'group_' . $group->id;
                    if ($group->type === 'radio') {
                        $this->selectedOptions[$key] = $selectedIdsInGroup[0] ?? null;
                    } else {
                        $this->selectedOptions[$key] = $selectedIdsInGroup;
                    }
                }
            } else {
                $this->cartItemId = null;
                $this->cartItem = null;
                $this->initializeSelectedOptions();
            }
        } else {
            $this->initializeSelectedOptions();
        }

        $this->calculatePrice();
    }

    public function initializeSelectedOptions()
    {
        foreach ($this->customizationGroups as $group) {
            $key = 'group_' . $group->id;
            if ($group->type === 'radio') {
                $this->selectedOptions[$key] = null; 
            } else {
                $this->selectedOptions[$key] = []; 
            }
        }
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

    public function saveToCart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
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

        file_put_contents(storage_path('logs/debug_cart.txt'), json_encode([
            'selectedOptions' => $this->selectedOptions,
            'selectedOptionIds' => $selectedOptionIds,
            'cartItemId' => $this->cartItemId
        ]) . PHP_EOL, FILE_APPEND);

        try {
            if ($this->cartItem) {
                $this->cartItem->update([
                    'quantity'   => $this->quantity,
                    'unit_price' => $unitPrice,
                    'subtotal'   => $subtotal,
                    'notes'      => $this->notes,
                ]);
                
                $this->cartItem->optionValues()->sync($selectedOptionIds);

            } else {
                $existingItem = $cart->items()
                    ->where('product_id', $this->product->id)
                    ->with('optionValues:id')
                    ->get()
                    ->first(function ($item) use ($selectedOptionIds) {
                        $itemOptionIds = $item->optionValues->pluck('id')->all();
                        sort($itemOptionIds);
                        return $itemOptionIds === $selectedOptionIds;
                    });

                if ($existingItem) {
                    $newQuantity = $existingItem->quantity + $this->quantity;
                    $newSubtotal = $unitPrice * $newQuantity;
                    $existingItem->update([
                        'quantity' => $newQuantity,
                        'subtotal' => $newSubtotal,
                    ]);
                } else {
                    $newItem = $cart->items()->create([
                        'product_id' => $this->product->id,
                        'quantity'   => $this->quantity,
                        'unit_price' => $unitPrice,
                        'subtotal'   => $subtotal,
                        'notes'      => $this->notes,
                    ]);
                    
                    $newItem->optionValues()->attach($selectedOptionIds);
                }
            }
            $this->dispatch('show-success', 'Barang berhasil disimpan ke keranjang!');            
            
            if ($this->cartItemId) {
                return redirect()->route('cart');
            } else {
                return redirect()->route('products.list');
            }

        } catch (\Exception $e) {
            Log::error('Error saving item to cart: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menyimpan barang.');
        }
    }

    public function resetTopping($groupId)
    {
        $group = $this->customizationGroups->firstWhere('id', $groupId);
        $key = 'group_' . $groupId;
        if ($group && $group->type === 'radio') {
            $this->selectedOptions[$key] = null;
        } else {
            $this->selectedOptions[$key] = [];
        }
        $this->calculatePrice();
    }

    public function render()
    {
        return view('livewire.products.product-customize');
    }
}

