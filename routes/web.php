<?php

use App\Livewire\Cart\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\CustomerHistory\CustomerHistoryDetailPage;
use App\Livewire\CustomerHistory\CustomerHistoryPage;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductCustomize;
use App\Livewire\UploadPaymentProof;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('products.list');
    }

    return view('welcome');
});


Route::middleware(['auth', 'customer'])->group(function () {


    Route::get('/cart', CartPage::class)->name('cart');
    Route::get('/products', ProductList::class)->name('products.list');
    Route::get('/products/{product}/customize', ProductCustomize::class)->name('product.customize');
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/history/{order}/upload-proof', UploadPaymentProof::class)->name('customer-history.upload-proof');
    Route::get('/history', CustomerHistoryPage::class)->name('customer-history.list');
    Route::get('/history/{orderId}', CustomerHistoryDetailPage::class)->name('customer-history.detail');
});












