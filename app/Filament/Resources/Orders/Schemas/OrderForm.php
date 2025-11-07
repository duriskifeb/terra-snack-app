<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Pelanggan')
                    ->placeholder('Pilih pelanggan')
                    ->searchable()
                    ->preload()
                    ->default(null),
                    
                TextInput::make('packaging_fee_per_item')
                    ->label('Biaya Packaging per Item')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0.0)
                    ->helperText('Biaya packaging untuk setiap item'),
                    
                TextInput::make('packaging_fee_total')
                    ->label('Total Biaya Packaging')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0.0)
                    ->helperText('Total biaya packaging untuk semua item'),
                    
                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->helperText('Total harga termasuk produk dan packaging'),
                    
                Select::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->default('pending')
                    ->required()
                    ->helperText('Status pesanan saat ini'),
                    
                TextInput::make('gateway_ref')
                    ->label('Referensi Pembayaran')
                    ->placeholder('Contoh: TRX-123456')
                    ->default(null)
                    ->helperText('Referensi dari gateway pembayaran'),
                    
                TextInput::make('gross_amount')
                    ->label('Jumlah Kotor')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(null)
                    ->helperText('Jumlah sebelum potongan/pajak'),
                    
                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Bayar',
                        'pending_payment' => 'Menunggu Pembayaran',
                        'paid' => 'Lunas',
                        'expired' => 'Kadaluarsa',
                        'failed' => 'Gagal',
                    ])
                    ->default('unpaid')
                    ->required()
                    ->helperText('Status pembayaran pesanan'),
                    
                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->placeholder('Contoh: Cash, QRIS, Transfer')
                    ->default(null)
                    ->helperText('Metode pembayaran yang digunakan'),
            ]);
    }
}