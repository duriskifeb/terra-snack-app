<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('customer_name')
                    ->label('Atas Nama')
                    ->placeholder('Nama pelanggan')
                    ->required()
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->default('pending')
                    ->required(),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Bayar',
                        'pending_verification' => 'Menunggu Verifikasi',
                        'paid' => 'Lunas',
                        'expired' => 'Kadaluarsa',
                    ])
                    ->default('unpaid')
                    ->required(),

                TextInput::make('packaging_fee_per_item')
                    ->label('Biaya Packaging per Item')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0.00)
                    ->required(),

                TextInput::make('packaging_fee_total')
                    ->label('Total Biaya Packaging')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0.00)
                    ->required(),

                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('gross_amount')
                    ->label('Jumlah Kotor')
                    ->numeric()
                    ->prefix('Rp')
                    ->nullable(),

                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->placeholder('Cash / QRIS / Transfer')
                    ->nullable(),

                DateTimePicker::make('paid_at')
                    ->label('Dibayar Pada')
                    ->nullable()
                    ->seconds(false),
            ]);
    }
}
