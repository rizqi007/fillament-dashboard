<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompletedOrdersExport implements FromCollection
{
    public function collection()
    {
        return Order::where('status', 'sudah Terkirim')->get();
    }
}
