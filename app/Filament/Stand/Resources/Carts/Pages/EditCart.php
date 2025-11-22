<?php

namespace App\Filament\Stand\Resources\Carts\Pages;

use App\Filament\Stand\Resources\Carts\CartResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCart extends EditRecord
{
    protected static string $resource = CartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
