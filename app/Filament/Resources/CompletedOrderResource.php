<?php

use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CompletedOrderResource extends Resource
{
    protected static ?string $model = Order::class;

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(fn (Order $query) => $query->where('status', 'sudah Terkirim'))
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('customer_name')->sortable(),
                TextColumn::make('total_price')->money('IDR')->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompletedOrders::route('/'),
        ];
    }
}
