<?php

namespace App\Filament\Resources\CustomizationOptions\Pages;

use App\Filament\Resources\CustomizationOptions\CustomizationOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomizationOption extends CreateRecord
{
    protected static string $resource = CustomizationOptionResource::class;
}
