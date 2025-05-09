<?php

namespace App\Filament\Resources\CompletedOrderResource\Pages;

use App\Filament\Resources\CompletedOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompletedOrder extends CreateRecord
{
    protected static string $resource = CompletedOrderResource::class;
}
