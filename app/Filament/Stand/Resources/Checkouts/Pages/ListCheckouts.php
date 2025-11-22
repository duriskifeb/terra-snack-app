<?php

namespace App\Filament\Stand\Resources\Checkouts\Pages;

use App\Filament\Stand\Resources\Checkouts\CheckoutResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCheckouts extends ListRecords
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
