<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\CsController;
use Modules\SCM\Http\Controllers\UnitController;
use Modules\SCM\Http\Controllers\IndentController;
use Modules\SCM\Http\Controllers\CourierController;
use Modules\SCM\Http\Controllers\MaterialController;
use Modules\SCM\Http\Controllers\SupplierController;
use Modules\SCM\Http\Controllers\ScmRequisitionController;
use Modules\SCM\Http\Controllers\ScmPurchaseRequisitionController;

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

Route::prefix('scm')->middleware(['auth'])->group(function() {
    Route::resources([
        'suppliers'                 => SupplierController::class,
        'units'                     => UnitController::class,
        'materials'                 => MaterialController::class,
        'couriers'                  => CourierController::class,
        'requisitions'              => ScmRequisitionController::class,
        'purchase-requisitions'     => ScmPurchaseRequisitionController::class,
        'cs'                        => CsController::class,
        'indents'                   => IndentController::class,
    ]);
});
