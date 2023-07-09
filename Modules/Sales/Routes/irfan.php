<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;

Route::resources([
    'sales' => SaleController::class,
]);

Route::get('get_client_info_for_sales', [SaleController::class, 'getClientInfoForSales'])->name('get_client_info_for_sales');
Route::get('get_frs_based_on_mq', [SaleController::class, 'getFrsBasedOnMq'])->name('get_frs_based_on_mq');
Route::get('test_test_test', [SaleController::class, 'testTestTest'])->name('test_test_test');
Route::post('updateAddress', [SaleController::class, 'updateAddress'])->name('updateAddress');
Route::get('get_employees', [SaleController::class, 'getEmployees'])->name('get_employees');
