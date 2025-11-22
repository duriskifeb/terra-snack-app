<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
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
                    ->default(null),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                Select::make('payment_status')
                    ->options([
            'unpaid' => 'Unpaid',
            'pending_verification' => 'Pending verification',
            'paid' => 'Paid',
            'expired' => 'Expired',
        ])
                    ->default('unpaid')
                    ->required(),
                TextInput::make('packaging_fee_per_item')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('packaging_fee_total')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_price')
                    ->required()
                    ->numeric(),
                TextInput::make('gross_amount')
                    ->numeric()
                    ->default(null),
                TextInput::make('payment_method')
                    ->default(null),
                TextInput::make('payment_proof')
                    ->default(null),
                DateTimePicker::make('paid_at'),
            ]);
    }
}
