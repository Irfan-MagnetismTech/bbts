<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\UnitController;
use Modules\SCM\Http\Controllers\CourierController;
use Modules\SCM\Http\Controllers\CsController;
use Modules\SCM\Http\Controllers\IndentController;
use Modules\SCM\Http\Controllers\MaterialController;
use Modules\SCM\Http\Controllers\PurchaseOrderController;
use Modules\SCM\Http\Controllers\ScmPurchaseRequisitionController;
use Modules\SCM\Http\Controllers\SupplierController;
use Modules\SCM\Http\Controllers\ScmRequisitionController;

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

Route::prefix('scm')->middleware(['auth'])->group(function () {
    Route::resources([
        'suppliers'                 => SupplierController::class,
        'units'                     => UnitController::class,
        'materials'                 => MaterialController::class,
        'couriers'                  => CourierController::class,
        'requisitions'              => ScmRequisitionController::class,
        'purchase-requisitions'     => ScmPurchaseRequisitionController::class,
        'cs'                        => CsController::class,
        'indents'                   => IndentController::class,
        'purchase-orders'           => PurchaseOrderController::class,
    ]);
    Route::get('search-material-by-cs-requisition/{csId}/{rqId}', [PurchaseOrderController::class, 'searchMaterialByCsAndRequsiition'])->name('search-material-by-cs-requisition');
    Route::get('search-material-price-by-cs-requisition/{csId}/{supplierId}/{materialId}', [PurchaseOrderController::class, 'searchMaterialPriceByCsAndRequsiition'])->name('search-material-price-by-cs-requisition');
});
