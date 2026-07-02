<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cart = App\Models\User::find(1)->cart;
if($cart) {
    $ci = $cart->items()->first();
    if($ci) {
        $ci->optionValues()->sync([1]);
        echo 'Synced option 1. ';
        print_r($ci->optionValues()->pluck('option_value_id')->all());
    } else {
        echo 'No CartItem found';
    }
} else {
    echo 'No cart found';
}
