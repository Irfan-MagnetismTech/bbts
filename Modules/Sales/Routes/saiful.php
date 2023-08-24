<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;

Route::resources([
    'sales' => SaleController::class,
]);

Route::get('generate_pnl_summary_pdf/{id}', [SaleController::class, 'pdf'])->name('generate_pnl_summary_pdf');
