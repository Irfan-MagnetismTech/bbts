<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\PurchaseOrderController;
use Modules\SCM\Http\Controllers\ScmMirController;

Route::get('search-material-price-by-cs-requisition/{csId}/{supplierId}/{materialId}', [PurchaseOrderController::class, 'searchMaterialPriceByCsAndRequsiition'])->name('search-material-price-by-cs-requisition');
Route::get('search_mrs_no', [ScmMirController::class, 'searchMrs'])->name('search_mrs_no');
Route::get('search-type-no', [ScmMirController::class, 'searchTypeNo'])->name('searchTypeNo');


Route::resources([
    'material-issues' => ScmMirController::class,
]);