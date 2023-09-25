<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillGenerateController;
use Modules\Billing\Http\Controllers\BillRegisterController;
use Modules\Billing\Http\Controllers\MonthlyBillController;
use Modules\Billing\Http\Controllers\BillingOtcBillController;
use Modules\Billing\Http\Controllers\BrokenDaysBillController;
use Modules\Billing\Http\Controllers\CollectionController;

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
        'monthly-bills'     => MonthlyBillController::class,
        'otc-bills'         => BillingOtcBillController::class,
        'bill-generate'     => BillGenerateController::class,
        'bill-register'     => BillRegisterController::class,
        'broken-days-bills' => BrokenDaysBillController::class,
        'collections'       => CollectionController::class,
    ]);
    Route::get('generate_otc_bill/{client_no}', [BillGenerateController::class, 'create'])->name('generate_otc_bill');
    Route::get('generate_otc_bill_pdf/{id}', [BillGenerateController::class, 'pdf'])->name('generate_otc_bill_pdf');
    Route::get('generate_bill/{id}', [BillGenerateController::class, 'generate_bill'])->name('generate_bill');
    Route::get('mrc_bill/{id}', [MonthlyBillController::class, 'mrc_bill'])->name('mrc_bill');
    Route::get('mrc_bill_summary/{id}', [MonthlyBillController::class, 'mrc_bill_summary'])->name('mrc_bill_summary');
    Route::get('mrc_bill_except_penalty/{id}', [MonthlyBillController::class, 'mrc_bill_except_penalty'])->name('mrc_bill_except_penalty');
    Route::get('mrc_bill_summary_except_penalty/{id}', [MonthlyBillController::class, 'mrc_bill_summary_except_penalty'])->name('mrc_bill_summary_except_penalty');
    Route::get('mrc_bill_except_due/{id}', [MonthlyBillController::class, 'mrc_bill_except_due'])->name('mrc_bill_except_due');
    Route::get('get_bill', [CollectionController::class, 'get_bill'])->name('get_bill');
    Route::get('get_fr_product', [BrokenDaysBillController::class, 'get_fr_product'])->name('get_fr_product');
    Route::get('get_fr_bill_date', [BrokenDaysBillController::class, 'get_fr_bill_date'])->name('get_fr_bill_date');
    Route::get('get_client', [BrokenDaysBillController::class, 'get_client'])->name('get_client');
    Route::get('get_supplier', [BillRegisterController::class, 'get_supplier'])->name('get_supplier');
});
