<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Modules\Sales\Http\Controllers\ReportController;

Route::get('plan-report', [ReportController::class, 'planReport'])->name('plan-report');
Route::get('plan-modification-report', [ReportController::class, 'planModificationReport'])->name('plan-modification-report');
Route::get('monthly-sales-summary-report', [ReportController::class, 'monthlySalesSummaryReport'])->name('monthly-sales-summary-report');
