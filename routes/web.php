<?php

use App\Http\Controllers\Api\MidtransWebhookController;
use App\Livewire\Cart\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductCustomize;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', CartPage::class)
    ->middleware('web')
    ->name('cart');

Route::get('/products', ProductList::class)
    ->middleware('web')
    ->name('products.list');

Route::get('/products/{product}/customize', ProductCustomize::class)
    ->middleware('web')
    ->name('product.customize');

Route::get('/checkout', CheckoutPage::class)
    ->middleware('web') 
    ->name('checkout');