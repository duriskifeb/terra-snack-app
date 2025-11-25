<?php

namespace App\Filament\Stand\Resources\Checkouts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CheckoutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Informasi Pelanggan')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('total_price')
                            ->label('Total Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Section::make('Status Pesanan')
                    ->schema([
                        Select::make('status')
                            ->label('Status Order')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->native(false),

                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'paid' => 'Paid',
                                'pending_verification' => 'Pending Verification',
                                'expired' => 'Expired',
                            ])
                            ->required()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'paid') {
                                    $set('paid_at', now());
                                }
                            }),

                        Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'cash' => 'Cash',
                                'qris' => 'QRIS',
                                'transfer' => 'Transfer Bank',
                            ])
                            ->required()
                            ->native(false),

                        DateTimePicker::make('paid_at')
                            ->label('Tanggal Pembayaran')
                            ->displayFormat('d/m/Y H:i')
                            ->seconds(false)
                            ->native(false)
                            ->visible(fn ($get) => $get('payment_status') === 'paid'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Section::make('Detail Biaya')
                    ->schema([
                        TextInput::make('gross_amount')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('packaging_fee_per_item')
                            ->label('Biaya Packaging/Item')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),

                        TextInput::make('packaging_fee_total')
                            ->label('Total Biaya Packaging')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(3)
                    ->columnSpan(2)
                    ->collapsible(),
            ]);
    }
}