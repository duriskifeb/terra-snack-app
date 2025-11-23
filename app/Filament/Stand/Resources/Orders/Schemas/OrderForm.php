<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Wizard::make([

                    Step::make('Pilih Item')
                        ->icon(Heroicon::ShoppingBag)
                        ->schema([
                            Repeater::make('items')
                                ->label('Item Pesanan')
                                ->schema([
                                    Select::make('product_type')
                                        ->label('Jenis Produk')
                                        ->options([
                                            'snack' => 'Snack',
                                            'drink' => 'Minuman',
                                        ])
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state === 'drink') {
                                                $set('vegetable', null);
                                                $set('topping', null);
                                                $set('sauce', null);
                                            }
                                        })
                                        ->columnSpan(2),

                                    Select::make('vegetable')
                                        ->label('Sayur')
                                        ->options([
                                            'tomato' => 'Tomat',
                                            'cucumber' => 'Timun',
                                            'sawi' => 'Sawi',
                                            'none' => 'Tanpa sayur',
                                        ])
                                        ->default('none')
                                        ->visible(fn($get) => $get('product_type') === 'snack')
                                        ->columnSpan(1),

                                    Select::make('topping')
                                        ->label('Topping')
                                        ->options([
                                            'mix_beef' => 'Mix Beef',
                                            'mix_chicken' => 'Mix Chicken',
                                            'mix_beef_chicken' => 'Mix Beef & Chicken',
                                            'none' => 'Tanpa topping',
                                        ])
                                        ->default('none')
                                        ->visible(fn($get) => $get('product_type') === 'snack')
                                        ->columnSpan(1),

                                    Select::make('sauce')
                                        ->label('Saus')
                                        ->options([
                                            'tartar' => 'Tar-Tar',
                                            'marinara' => 'Marinara',
                                            'cheese' => 'Cheese',
                                            'mixed' => 'Mixed',
                                            'none' => 'Tanpa saus',
                                        ])
                                        ->default('none')
                                        ->visible(fn($get) => $get('product_type') === 'snack')
                                        ->columnSpan(1),

                                    TextInput::make('quantity')
                                        ->label('Jumlah')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live(onBlur: true)
                                        ->columnSpan(1),

                                    TextInput::make('price')
                                        ->label('Harga Satuan')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->columnSpan(1),
                                ])
                                ->columns(3)
                                ->defaultItems(1)
                                ->addActionLabel('Tambah Item')
                                ->reorderable()
                                ->collapsible()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $total = 0;
                                    if (is_array($state)) {
                                        foreach ($state as $item) {
                                            $price = floatval($item['price'] ?? 0);
                                            $quantity = intval($item['quantity'] ?? 1);
                                            $total += $price * $quantity;
                                        }
                                    }
                                    $set('total_price', $total);
                                })
                                ->itemLabel(fn (array $state): ?string => 
                                    ($state['product_type'] ?? 'Item') . 
                                    ' x' . ($state['quantity'] ?? 1)
                                ),
                        ]),

                    Step::make('Checkout')
                        ->icon(Heroicon::CreditCard)
                        ->completedIcon(Heroicon::CheckCircle)
                        ->schema([
                            TextInput::make('customer_name')
                                ->label('Nama Pelanggan')
                                ->required(),

                            TextInput::make('total_price')
                                ->label('Total Harga')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->readOnly()
                                ->helperText('Total dihitung otomatis dari semua item'),

                            Select::make('payment_method')
                                ->label('Metode Pembayaran')
                                ->options([
                                    'cash' => 'Cash',
                                    'qris' => 'QRIS',
                                    'transfer' => 'Transfer',
                                ])
                                ->required(),
                        ]),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button type="submit" size="sm">
                        Buat Pesanan
                    </x-filament::button>
                BLADE))),
            ]);
    }
}