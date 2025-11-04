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
                    ->default(null),
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
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('gateway_ref')
                    ->default(null),
                TextInput::make('gross_amount')
                    ->numeric()
                    ->default(null),
                Select::make('payment_status')
                    ->options([
            'unpaid' => 'Unpaid',
            'pending_payment' => 'Pending payment',
            'paid' => 'Paid',
            'expired' => 'Expired',
            'failed' => 'Failed',
        ])
                    ->default('unpaid')
                    ->required(),
                TextInput::make('payment_method')
                    ->default(null),
            ]);
    }
}
