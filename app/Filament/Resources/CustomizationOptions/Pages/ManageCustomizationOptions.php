<?php

namespace App\Filament\Resources\CustomizationOptions\Pages;

use App\Filament\Resources\CustomizationOptions\CustomizationOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCustomizationOptions extends ManageRecords
{
    protected static string $resource = CustomizationOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
