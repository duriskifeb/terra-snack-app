<?php

namespace App\Filament\Resources\CustomizationOptions\Pages;

use App\Filament\Resources\CustomizationOptions\CustomizationOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomizationOptions extends ListRecords
{
    protected static string $resource = CustomizationOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
