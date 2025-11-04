<?php

use App\Livewire\Cart\CartPage;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/cart', CartPage::class)
    ->middleware('web') 
    ->name('cart.index');