<?php

namespace App\Filament\Stand\Resources\Checkouts;

use App\Filament\Stand\Resources\Checkouts\Pages\CreateCheckout;
use App\Filament\Stand\Resources\Checkouts\Pages\EditCheckout;
use App\Filament\Stand\Resources\Checkouts\Pages\ListCheckouts;
use App\Filament\Stand\Resources\Checkouts\Schemas\CheckoutForm;
use App\Filament\Stand\Resources\Checkouts\Tables\CheckoutsTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CheckoutResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = 'gmdi-shopping-cart-checkout-o';

    protected static ?string $navigationLabel = 'Checkouts';
    protected static ?string $pluralLabel = 'Checkouts';
    protected static ?string $modelLabel = 'Checkout';

    // untuk buat grup sidebar
    // protected static string|UnitEnum|null $navigationGroup = 'Order Management';


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
            'index'  => ListCheckouts::route('/'),
            'create' => CreateCheckout::route('/create'),
            'edit'   => EditCheckout::route('/{record}/edit'),
        ];
    }
}
