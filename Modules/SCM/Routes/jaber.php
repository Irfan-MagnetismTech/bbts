<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\PurchaseOrderController;
use Modules\SCM\Http\Controllers\ScmMirController;

Route::get('search-material-price-by-cs-requisition/{csId}/{supplierId}/{materialId}', [PurchaseOrderController::class, 'searchMaterialPriceByCsAndRequsiition'])->name('search-material-price-by-cs-requisition');

Route::resources([
    'material-issues' => ScmMirController::class,
]);