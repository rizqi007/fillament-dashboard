<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderExportController extends Controller
{
    public function export()
    {
        $orders = Order::where('status', 'sudah terkirim')->get(); // Ambil order yang sudah selesai

        $pdf = Pdf::loadView('exports.orders', compact('orders')); // Load view
        return $pdf->download('orders.pdf'); // Download sebagai PDF
    }
}
