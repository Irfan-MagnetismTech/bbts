<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Modules\Sales\Http\Controllers\ReportController;

Route::get('plan-report', [ReportController::class, 'planReport'])->name('plan-report');
Route::get('plan-modification-report', [ReportController::class, 'planModificationReport'])->name('plan-modification-report');
Route::get('monthly-sales-summary-report', [ReportController::class, 'monthlySalesSummaryReport'])->name('monthly-sales-summary-report');
Route::get('account-holder-wise-report', [ReportController::class, 'accountHolderWiseReport'])->name('account-holder-wise-report');
Route::get('product-wise-report', [ReportController::class, 'productWiseReport'])->name('product-wise-report');
Route::get('branch-wise-report', [ReportController::class, 'branchWiseReport'])->name('branch-wise-report');
