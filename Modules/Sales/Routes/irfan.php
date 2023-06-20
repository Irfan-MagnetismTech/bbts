<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;

Route::resources([
    'sales' => SaleController::class,
]);

Route::get('get_client_info_for_sales', [SaleController::class, 'getClientInfoForSales'])->name('get_client_info_for_sales');
