<?php
namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.customer')] 
class ProductList extends Component
{
    public $categories;
    public $activeCategoryId;

    public function mount()
    {
        $this->categories = Category::all();
        $this->activeCategoryId = $this->categories->first()->id ?? null;
    }

    public function filterByCategory($categoryId)
    {
        $this->activeCategoryId = $categoryId;
    }

    public function render()
    {
        $products = Product::where('category_id', $this->activeCategoryId)
            ->get();
        return view('livewire.products.product-list', [
            'products' => $products
        ]);
    }
}

