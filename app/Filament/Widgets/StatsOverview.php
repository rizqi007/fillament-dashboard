<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer; 
use App\Models\OrderItem;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // $penjualan = Order::where(''), false->sum(''),
        return [
            Card::make('Total Penjualan', 'Rp ' . number_format(Order::where('status', 'sudah terkirim')->sum('total_price'), 0, ',', '.'))
            ->icon('heroicon-o-currency-dollar')
            ->color('success'),

            Card::make('Total Barang Terjual', OrderItem::sum('quantity')) // Menjumlahkan jumlah barang terjual
            ->icon('heroicon-o-shopping-cart'), // Ikon keranjang

            Card::make('Total Pelanggan', Customer::count())
            ->icon('heroicon-o-user-group'), // Ikon pelanggan
        ];
    }
}
