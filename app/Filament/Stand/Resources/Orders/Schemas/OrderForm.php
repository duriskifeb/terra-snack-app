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

                    Step::make('Data Pelanggan')
                        ->icon(Heroicon::User)
                        ->description('Masukkan nama pelanggan')
                        ->schema([
                            TextInput::make('customer_name')
                                ->label('Nama Pelanggan')
                                ->placeholder('Masukkan nama pelanggan')
                                ->required()
                                ->maxLength(255),
                        ]),

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
                                    $customerName = $get('customer_name') ?? 'Belum diisi';
                                    $items = $get('items') ?? [];
                                    $vegetable = $get('vegetable') ?? 'none';
                                    $topping = $get('topping') ?? 'none';
                                    $sauce = $get('sauce') ?? 'none';
                                    
                                    if (empty($items)) {
                                        return 'Belum ada item yang dipilih';
                                    }
                                    
                                    $html = '<div class="space-y-6">';
                                    
                                    $html .= '<div class="bg-primary-50 dark:bg-primary-950 p-4 rounded-lg border-2 border-primary-200 dark:border-primary-800">';
                                    $html .= '<div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nama Pelanggan</div>';
                                    $html .= '<div class="text-2xl font-bold text-primary-700 dark:text-primary-300">' . htmlspecialchars($customerName) . '</div>';
                                    $html .= '</div>';

                                    $html .= '<div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">';
                                    $html .= '<div class="font-semibold text-base text-gray-800 dark:text-gray-200 mb-3">🎨 Customization</div>';
                                    $html .= '<div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">';
                                    $html .= '<div class="bg-white dark:bg-gray-950 p-3 rounded-lg">';
                                    $html .= '<span class="font-semibold text-gray-700 dark:text-gray-300">Sayur:</span> ';
                                    $html .= '<span class="text-gray-900 dark:text-gray-100">' . ucfirst($vegetable !== 'none' ? $vegetable : 'Tanpa sayur') . '</span>';
                                    $html .= '</div>';
                                    $html .= '<div class="bg-white dark:bg-gray-950 p-3 rounded-lg">';
                                    $html .= '<span class="font-semibold text-gray-700 dark:text-gray-300">Topping:</span> ';
                                    $html .= '<span class="text-gray-900 dark:text-gray-100">' . ucfirst($topping !== 'none' ? str_replace('_', ' ', $topping) : 'Tanpa topping') . '</span>';
                                    if ($topping !== 'none') {
                                        $html .= ' <span class="text-green-600 dark:text-green-400 font-semibold">(+Rp 5.000)</span>';
                                    }
                                    $html .= '</div>';
                                    $html .= '<div class="bg-white dark:bg-gray-950 p-3 rounded-lg">';
                                    $html .= '<span class="font-semibold text-gray-700 dark:text-gray-300">Saus:</span> ';
                                    $html .= '<span class="text-gray-900 dark:text-gray-100">' . ucfirst($sauce !== 'none' ? $sauce : 'Tanpa saus') . '</span>';
                                    $html .= '</div>';
                                    $html .= '</div></div>';
                                    
                                    $html .= '<div>';
                                    $html .= '<div class="font-semibold text-base text-gray-800 dark:text-gray-200 mb-3">🍽️ Daftar Item</div>';
                                    $html .= '<div class="space-y-3">';
                                    $totalQty = 0;
                                    $subtotal = 0;
                                    $counter = 1;
                                    
                                    foreach ($items as $item) {
                                        $qty = intval($item['quantity'] ?? 1);
                                        $price = 20000;
                                        $itemTotal = $qty * $price;
                                        $totalQty += $qty;
                                        $subtotal += $itemTotal;
                                        
                                        $html .= '<div class="bg-white dark:bg-gray-900 p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-sm">';
                                        $html .= '<div class="flex justify-between items-center">';
                                        $html .= '<div class="flex-1">';
                                        $html .= '<div class="font-bold text-lg text-gray-900 dark:text-gray-100">Snack #' . $counter . '</div>';
                                        $html .= '<div class="text-sm text-gray-600 dark:text-gray-400 mt-1">';
                                        $html .= '<span class="font-medium">' . $qty . ' pcs</span> × Rp ' . number_format($price, 0, ',', '.');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-right">';
                                        $html .= '<div class="text-xl font-bold text-primary-600 dark:text-primary-400">';
                                        $html .= 'Rp ' . number_format($itemTotal, 0, ',', '.');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        $counter++;
                                    }
                                    
                                    $html .= '</div></div>';
                                    
                                    $usePackaging = $get('use_packaging') ?? false;
                                    $toppingFee = ($topping !== 'none') ? ($totalQty * 5000) : 0;
                                    $packagingFee = $usePackaging ? ($totalQty * 1000) : 0;
                                    $grandTotal = $subtotal + $toppingFee + $packagingFee;
                                    
                                    $html .= '<div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-950 dark:to-primary-900 p-5 rounded-lg border-2 border-primary-300 dark:border-primary-700">';
                                    $html .= '<div class="font-semibold text-base text-gray-800 dark:text-gray-200 mb-4">💰 Rincian Biaya</div>';
                                    $html .= '<div class="space-y-2">';
                                    
                                    $html .= '<div class="flex justify-between text-sm py-2 border-b border-primary-200 dark:border-primary-800">';
                                    $html .= '<span class="text-gray-700 dark:text-gray-300">Total Item:</span>';
                                    $html .= '<span class="font-semibold text-gray-900 dark:text-gray-100">' . $totalQty . ' pcs</span>';
                                    $html .= '</div>';
                                    
                                    $html .= '<div class="flex justify-between text-sm py-2 border-b border-primary-200 dark:border-primary-800">';
                                    $html .= '<span class="text-gray-700 dark:text-gray-300">Subtotal Snack:</span>';
                                    $html .= '<span class="font-semibold text-gray-900 dark:text-gray-100">Rp ' . number_format($subtotal, 0, ',', '.') . '</span>';
                                    $html .= '</div>';
                                    
                                    if ($toppingFee > 0) {
                                        $html .= '<div class="flex justify-between text-sm py-2 border-b border-primary-200 dark:border-primary-800">';
                                        $html .= '<span class="text-green-700 dark:text-green-300">Biaya Topping (' . $totalQty . ' × Rp 5.000):</span>';
                                        $html .= '<span class="font-semibold text-green-700 dark:text-green-300">Rp ' . number_format($toppingFee, 0, ',', '.') . '</span>';
                                        $html .= '</div>';
                                    }
                                    
                                    if ($packagingFee > 0) {
                                        $html .= '<div class="flex justify-between text-sm py-2 border-b border-primary-200 dark:border-primary-800">';
                                        $html .= '<span class="text-blue-700 dark:text-blue-300">Biaya Packaging (' . $totalQty . ' × Rp 1.000):</span>';
                                        $html .= '<span class="font-semibold text-blue-700 dark:text-blue-300">Rp ' . number_format($packagingFee, 0, ',', '.') . '</span>';
                                        $html .= '</div>';
                                    }
                                    
                                    $html .= '<div class="flex justify-between items-center pt-4 mt-2 border-t-2 border-primary-400 dark:border-primary-600">';
                                    $html .= '<span class="text-xl font-bold text-gray-900 dark:text-gray-100">TOTAL PEMBAYARAN</span>';
                                    $html .= '<span class="text-3xl font-extrabold text-primary-600 dark:text-primary-400">Rp ' . number_format($grandTotal, 0, ',', '.') . '</span>';
                                    $html .= '</div>';
                                    $html .= '</div></div>';
                                    
                                    $html .= '</div>';
                                    
                                    return new HtmlString($html);
                                })
                                ->columnSpanFull(),
                        ]),

                    Step::make('Checkout')
                        ->icon(Heroicon::CreditCard)
                        ->completedIcon(Heroicon::CheckCircle)
                        ->schema([
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