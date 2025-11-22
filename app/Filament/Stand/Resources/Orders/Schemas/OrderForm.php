<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                // Step tracker
                Select::make('step')
                    ->label('Step')
                    ->options([
                        1 => 'Pilih Produk',
                        2 => 'Pilih Sayur',
                        3 => 'Pilih Topping',
                        4 => 'Pilih Saus',
                        5 => 'Checkout',
                    ])
                    ->default(1),

                // STEP 1: Produk
                Select::make('product')
                    ->label('Pilih Produk')
                    ->options([
                        'snack' => 'Snack',
                        'drink' => 'Minuman',
                    ])
                    ->required()
                    ->visible(fn($get) => $get('step') === 1),

                // STEP 2: Sayur
                Select::make('vegetable')
                    ->label('Pilih Sayur (Opsional)')
                    ->options([
                        'tomato' => 'Tomato',
                        'cucumber' => 'Timun',
                        'sawi' => 'Sawi',
                    ])
                    ->nullable()
                    ->visible(fn($get) => $get('step') === 2),

                // STEP 3: Topping
                Select::make('topping')
                    ->label('Pilih Topping')
                    ->options([
                        'mix_beef' => 'Mix Beef',
                        'mix_chicken' => 'Mix Chicken',
                        'mix_beef_chicken' => 'Mix Beef & Chicken',
                    ])
                    ->required()
                    ->visible(fn($get) => $get('step') === 3),

                // STEP 4: Saus
                Select::make('sauce')
                    ->label('Pilih Saus')
                    ->options([
                        'tartar' => 'Tar-Tar',
                        'marinara' => 'Marinara',
                        'cheese' => 'Cheese',
                        'mixed' => 'Mixed',
                    ])
                    ->required()
                    ->visible(fn($get) => $get('step') === 4),

                // STEP 5: Checkout
                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->visible(fn($get) => $get('step') === 5),

                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->visible(fn($get) => $get('step') === 5),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Cash',
                        'qris' => 'QRIS',
                        'transfer' => 'Transfer',
                    ])
                    ->required()
                    ->visible(fn($get) => $get('step') === 5),
            ]);
    }
}
