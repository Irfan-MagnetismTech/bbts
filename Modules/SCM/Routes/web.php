<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\CourierController;
use Modules\SCM\Http\Controllers\UnitController;
use Modules\SCM\Http\Controllers\MaterialController;
use Modules\SCM\Http\Controllers\SupplierController;

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

Route::prefix('scm')->group(function() {
    Route::resources([
        'suppliers'     => SupplierController::class,
        'units'         => UnitController::class,
        'materials'     => MaterialController::class,
        'couriers'      => CourierController::class,
    ]);
});
