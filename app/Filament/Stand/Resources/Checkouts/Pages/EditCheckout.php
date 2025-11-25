<?php

namespace App\Filament\Stand\Resources\Checkouts\Pages;

use App\Filament\Stand\Resources\Checkouts\CheckoutResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCheckout extends EditRecord
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
