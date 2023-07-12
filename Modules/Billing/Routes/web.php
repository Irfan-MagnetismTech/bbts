<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillGenerateController;
use Modules\Billing\Http\Controllers\MonthlyBillController;
use Modules\Billing\Http\Controllers\BillingOtcBillController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('billing')->middleware(['auth'])->group(function () {
    Route::get('/', 'BillingController@index');

    Route::resources([
        'monthly-bills' => MonthlyBillController::class,
        'otc-bills'     => BillingOtcBillController::class,
    ]);
    Route::get('generate_otc_bill/{client_no}', [BillGenerateController::class, 'create'])->name('generate_otc_bill');
});
