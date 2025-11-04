<?php

namespace App\Filament\Resources\CustomizationOptions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomizationOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
            ]);
    }
}
