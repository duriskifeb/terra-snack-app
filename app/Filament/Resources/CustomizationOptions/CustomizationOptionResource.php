<?php

namespace App\Filament\Resources\CustomizationOptions;

use App\Filament\Resources\CustomizationOptions\Pages\CreateCustomizationOption;
use App\Filament\Resources\CustomizationOptions\Pages\EditCustomizationOption;
use App\Filament\Resources\CustomizationOptions\Pages\ListCustomizationOptions;
use App\Filament\Resources\CustomizationOptions\Schemas\CustomizationOptionForm;
use App\Filament\Resources\CustomizationOptions\Tables\CustomizationOptionsTable;
use App\Models\CustomizationOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomizationOptionResource extends Resource
{
    protected static ?string $model = CustomizationOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CustomizationOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomizationOptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomizationOptions::route('/'),
            'create' => CreateCustomizationOption::route('/create'),
            'edit' => EditCustomizationOption::route('/{record}/edit'),
        ];
    }
}
