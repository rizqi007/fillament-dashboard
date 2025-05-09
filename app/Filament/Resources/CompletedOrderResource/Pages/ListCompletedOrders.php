<?php

namespace App\Filament\Resources\CompletedOrderResource\Pages;

use App\Filament\Resources\CompletedOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompletedOrders extends ListRecords
{
    protected static string $resource = CompletedOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
