<?php

namespace App\Filament\Stand\Resources\Checkouts;

use App\Filament\Stand\Resources\Checkouts\Pages\EditCheckout;
use App\Filament\Stand\Resources\Checkouts\Pages\ListCheckouts;
use App\Filament\Stand\Resources\Checkouts\Schemas\CheckoutForm;
use App\Filament\Stand\Resources\Checkouts\Tables\CheckoutsTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CheckoutResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = 'gmdi-shopping-cart-checkout-o';

    protected static ?string $navigationLabel = 'Daftar Pesanan';
    protected static ?string $pluralLabel = 'Daftar Pesanan';
    protected static ?string $modelLabel = 'Pesanan';
    protected static ?int $navigationSort = 3;
    // protected static string|UnitEnum|null $navigationGroup = 'Manajemen Pesanan';

    public static function form(Schema $schema): Schema
    {
        return CheckoutForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CheckoutsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCheckouts::route('/'),
            'edit' => EditCheckout::route('/{record}/edit'),
            // 'create' => CreateCheckout::route('/create'), ← HAPUS INI
        ];
    }
    
    // Disable create button
    public static function canCreate(): bool
    {
        return false;
    }
}