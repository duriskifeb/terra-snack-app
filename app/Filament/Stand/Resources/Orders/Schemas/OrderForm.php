<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

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
                    Step::make('Pilih Produk')
                        ->icon(Heroicon::ShoppingBag)
                        ->schema([
                            Select::make('product')
                                ->label('Pilih Produk')
                                ->options([
                                    'snack' => 'Snack',
                                    'drink' => 'Minuman',
                                ])
                                ->required(),
                        ]),

                    Step::make('Pilih Sayur')
                        ->icon('iconpark-vegetables-o') 
                        ->schema([
                            Select::make('vegetable')
                                ->label('Pilih Sayur (Opsional)')
                                ->options([
                                    'tomato' => 'Tomato',
                                    'cucumber' => 'Timun',
                                    'sawi' => 'Sawi',
                                ])
                                ->nullable(),
                        ]),

                    Step::make('Pilih Topping')
                        ->icon('rpg-meat')
                        ->schema([
                            Select::make('topping')
                                ->label('Pilih Topping')
                                ->options([
                                    'mix_beef' => 'Mix Beef',
                                    'mix_chicken' => 'Mix Chicken',
                                    'mix_beef_chicken' => 'Mix Beef & Chicken',
                                ])
                                ->required(),
                        ]),

                    Step::make('Pilih Saus')
                        ->icon('iconpark-bottleone-o') 
                        ->schema([
                            Select::make('sauce')
                                ->label('Pilih Saus')
                                ->options([
                                    'tartar' => 'Tar-Tar',
                                    'marinara' => 'Marinara',
                                    'cheese' => 'Cheese',
                                    'mixed' => 'Mixed',
                                ])
                                ->required(),
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
                                ->required(),

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
                        <x-filament::button
                            type="submit"
                            size="sm"
                        >
                            Buat Pesanan
                        </x-filament::button>
                    BLADE)))
            ]);
    }
}