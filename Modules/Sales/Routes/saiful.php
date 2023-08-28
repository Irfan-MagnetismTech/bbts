<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;

Route::resources([
    'sales' => SaleController::class,
]);

Route::get('generate_pnl_summary_pdf/{id}', [SaleController::class, 'pnlSummaryPdf'])->name('generate_pnl_summary_pdf');

Route::get('generate_pnl_details_pdf/{id}', [SaleController::class, 'pnlDetailsPdf'])->name('generate_pnl_details_pdf');
