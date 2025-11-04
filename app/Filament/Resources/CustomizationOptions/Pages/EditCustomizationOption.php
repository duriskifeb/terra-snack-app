<?php

namespace App\Filament\Resources\CustomizationOptions\Pages;

use App\Filament\Resources\CustomizationOptions\CustomizationOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomizationOption extends EditRecord
{
    protected static string $resource = CustomizationOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
