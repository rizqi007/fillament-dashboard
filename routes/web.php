<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/admin');

Route::get('/orders/export-pdf', [OrderExportController::class, 'export'])->name('orders.export-pdf');
