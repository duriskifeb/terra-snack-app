<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\Checkbox;
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

                    Step::make('Pilih Produk')
                        ->icon(Heroicon::ShoppingBag)
                        ->description('Tentukan jumlah snack yang dipesan')
                        ->schema([
                            Repeater::make('items')
                                ->label('Daftar Snack')
                                ->schema([
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
                                        ->default(20000)
                                        ->required()
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpan(1),
                                ])
                                ->columns(2)
                                ->defaultItems(1)
                                ->addActionLabel('Tambah Snack Lagi')
                                ->reorderable()
                                ->collapsible()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $total = 0;
                                    $totalItems = 0;

                                    if (is_array($state)) {
                                        foreach ($state as $item) {
                                            $price = 20000;
                                            $quantity = intval($item['quantity'] ?? 1);
                                            $total += $price * $quantity;
                                            $totalItems += $quantity;
                                        }
                                    }

                                    $usePackaging = $get('use_packaging') ?? false;
                                    $packagingFee = $usePackaging ? ($totalItems * 1000) : 0;
                                    
                                    $set('packaging_fee_total', $packagingFee);
                                    $set('packaging_fee_per_item', $usePackaging ? 1000 : 0);
                                    $set('total_price', $total + $packagingFee);
                                })
                                ->itemLabel(fn (array $state): ?string => 
                                    'Snack x' . ($state['quantity'] ?? 1) . ' = Rp ' . number_format(($state['quantity'] ?? 1) * 20000, 0, ',', '.')
                                ),
                        ]),

                    Step::make('Pilih Sayur')
                        ->icon('iconpark-vegetables-o')
                        ->description('Pilih sayur untuk semua snack')
                        ->schema([
                            Select::make('vegetable')
                                ->label('Sayur')
                                ->options([
                                    'tomato' => 'Tomat',
                                    'cucumber' => 'Timun',
                                    'sawi' => 'Sawi',
                                    'none' => 'Tanpa sayur',
                                ])
                                ->default('none')
                                ->required(),
                        ]),

                    Step::make('Pilih Topping')
                        ->icon('rpg-meat')
                        ->description('Pilih topping untuk semua snack (+Rp 5.000)')
                        ->schema([
                            Select::make('topping')
                                ->label('Topping')
                                ->options([
                                    'mix_beef' => 'Mix Beef (+Rp 5.000)',
                                    'mix_chicken' => 'Mix Chicken (+Rp 5.000)',
                                    'mix_beef_chicken' => 'Mix Beef & Chicken (+Rp 5.000)',
                                    'none' => 'Tanpa topping',
                                ])
                                ->default('none')
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $items = $get('items') ?? [];
                                    $totalItems = 0;
                                    $subtotal = 0;

                                    foreach ($items as $item) {
                                        $quantity = intval($item['quantity'] ?? 1);
                                        $totalItems += $quantity;
                                        $subtotal += 20000 * $quantity;
                                    }

                                    // Tambah biaya topping
                                    if ($state !== 'none') {
                                        $subtotal += $totalItems * 5000;
                                    }

                                    $usePackaging = $get('use_packaging') ?? false;
                                    $packagingFee = $usePackaging ? ($totalItems * 1000) : 0;
                                    $total = $subtotal + $packagingFee;

                                    $set('total_price', $total);
                                }),
                        ]),

                    Step::make('Pilih Saus')
                        ->icon('iconpark-bottleone-o')
                        ->description('Pilih saus untuk semua snack')
                        ->schema([
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
                                ->required(),

                            Checkbox::make('use_packaging')
                                ->label('Pakai Packaging')
                                ->helperText('Tambah Rp 1.000 per item')
                                ->default(false)
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $items = $get('items') ?? [];
                                    $topping = $get('topping') ?? 'none';
                                    $totalItems = 0;
                                    $subtotal = 0;

                                    foreach ($items as $item) {
                                        $quantity = intval($item['quantity'] ?? 1);
                                        $totalItems += $quantity;
                                        $subtotal += 20000 * $quantity;
                                    }

                                    // Tambah biaya topping
                                    if ($topping !== 'none') {
                                        $subtotal += $totalItems * 5000;
                                    }

                                    $packagingFee = $state ? ($totalItems * 1000) : 0;
                                    $total = $subtotal + $packagingFee;

                                    $set('packaging_fee_per_item', $state ? 1000 : 0);
                                    $set('packaging_fee_total', $packagingFee);
                                    $set('total_price', $total);
                                }),
                        ]),

                    Step::make('Review Order')
                        ->icon(Heroicon::ClipboardDocumentList)
                        ->description('Review pesanan sebelum checkout')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('order_summary')
                                ->label('Ringkasan Pesanan')
                                ->content(function ($get) {
                                    $items = $get('items') ?? [];
                                    $vegetable = $get('vegetable') ?? 'none';
                                    $topping = $get('topping') ?? 'none';
                                    $sauce = $get('sauce') ?? 'none';
                                    
                                    if (empty($items)) {
                                        return 'Belum ada item yang dipilih';
                                    }
                                    
                                    $html = '<div class="space-y-4">';
                                    
                                    // Header
                                    $html .= '<div class="font-semibold text-lg border-b pb-2">Detail Pesanan</div>';
                                    
                                    // Customization Global
                                    $html .= '<div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-2">';
                                    $html .= '<div class="font-medium text-sm text-gray-700 dark:text-gray-300">Customization (Berlaku untuk semua snack):</div>';
                                    $html .= '<div class="grid grid-cols-3 gap-2 text-sm">';
                                    $html .= '<div><span class="font-medium">Sayur:</span> ' . ucfirst($vegetable !== 'none' ? $vegetable : 'Tanpa sayur') . '</div>';
                                    $html .= '<div><span class="font-medium">Topping:</span> ' . ucfirst($topping !== 'none' ? str_replace('_', ' ', $topping) : 'Tanpa topping');
                                    if ($topping !== 'none') {
                                        $html .= ' <span class="text-green-600 dark:text-green-400">(+Rp 5.000)</span>';
                                    }
                                    $html .= '</div>';
                                    $html .= '<div><span class="font-medium">Saus:</span> ' . ucfirst($sauce !== 'none' ? $sauce : 'Tanpa saus') . '</div>';
                                    $html .= '</div></div>';
                                    
                                    // Items List
                                    $html .= '<div class="space-y-2">';
                                    $totalQty = 0;
                                    $subtotal = 0;
                                    $counter = 1;
                                    
                                    foreach ($items as $item) {
                                        $qty = intval($item['quantity'] ?? 1);
                                        $price = 20000;
                                        $itemTotal = $qty * $price;
                                        $totalQty += $qty;
                                        $subtotal += $itemTotal;
                                        
                                        $html .= '<div class="flex justify-between items-center p-3 bg-white dark:bg-gray-900 rounded border">';
                                        $html .= '<div class="flex-1">';
                                        $html .= '<div class="font-medium">Snack #' . $counter . '</div>';
                                        $html .= '<div class="text-sm text-gray-600 dark:text-gray-400">';
                                        $html .= $qty . ' pcs × Rp ' . number_format($price, 0, ',', '.');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-right font-semibold">';
                                        $html .= 'Rp ' . number_format($itemTotal, 0, ',', '.');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        $counter++;
                                    }
                                    
                                    $html .= '</div>';
                                    
                                    // Summary
                                    $usePackaging = $get('use_packaging') ?? false;
                                    $toppingFee = ($topping !== 'none') ? ($totalQty * 5000) : 0;
                                    $packagingFee = $usePackaging ? ($totalQty * 1000) : 0;
                                    $grandTotal = $subtotal + $toppingFee + $packagingFee;
                                    
                                    $html .= '<div class="border-t pt-4 space-y-2">';
                                    $html .= '<div class="flex justify-between text-sm">';
                                    $html .= '<span class="text-gray-600 dark:text-gray-400">Total Item:</span>';
                                    $html .= '<span class="font-medium">' . $totalQty . ' pcs</span>';
                                    $html .= '</div>';
                                    $html .= '<div class="flex justify-between text-sm">';
                                    $html .= '<span class="text-gray-600 dark:text-gray-400">Subtotal Snack:</span>';
                                    $html .= '<span class="font-medium">Rp ' . number_format($subtotal, 0, ',', '.') . '</span>';
                                    $html .= '</div>';
                                    
                                    if ($toppingFee > 0) {
                                        $html .= '<div class="flex justify-between text-sm text-green-600 dark:text-green-400">';
                                        $html .= '<span>Biaya Topping (' . $totalQty . ' × Rp 5.000):</span>';
                                        $html .= '<span class="font-medium">Rp ' . number_format($toppingFee, 0, ',', '.') . '</span>';
                                        $html .= '</div>';
                                    }
                                    
                                    if ($packagingFee > 0) {
                                        $html .= '<div class="flex justify-between text-sm text-blue-600 dark:text-blue-400">';
                                        $html .= '<span>Biaya Packaging (' . $totalQty . ' × Rp 1.000):</span>';
                                        $html .= '<span class="font-bold">Rp ' . number_format($packagingFee, 0, ',', '.') . '</span>';
                                        $html .= '</div>';
                                    }
                                    
                                    $html .= '<div class="flex justify-between text-lg font-bold border-t pt-2">';
                                    $html .= '<span>Total Pembayaran:</span>';
                                    $html .= '<span class="text-primary-600 dark:text-primary-400">Rp ' . number_format($grandTotal, 0, ',', '.') . '</span>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    
                                    $html .= '</div>';
                                    
                                    return new HtmlString($html);
                                })
                                ->columnSpanFull(),
                        ]),

                    Step::make('Checkout')
                        ->icon(Heroicon::CreditCard)
                        ->completedIcon(Heroicon::CheckCircle)
                        ->schema([
                            TextInput::make('customer_name')
                                ->label('Nama Pelanggan')
                                ->required()
                                ->columnSpanFull(),

                            TextInput::make('total_price')
                                ->label('Total Harga')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->readOnly()
                                ->helperText('Total sudah termasuk topping dan packaging')
                                ->columnSpanFull(),

                            Select::make('payment_method')
                                ->label('Metode Pembayaran')
                                ->options([
                                    'cash' => 'Cash',
                                    'qris' => 'QRIS',
                                    'transfer' => 'Transfer',
                                ])
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button type="submit" size="sm">
                        Buat Pesanan
                    </x-filament::button>
                BLADE))),
            ]);
    }
}