<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\ScmMirController;
use Modules\SCM\Http\Controllers\ScmGatePassController;
use Modules\SCM\Http\Controllers\PurchaseOrderController;

Route::get('search-material-price-by-cs-requisition/{csId}/{supplierId}/{materialId}', [PurchaseOrderController::class, 'searchMaterialPriceByCsAndRequsiition'])->name('search-material-price-by-cs-requisition');
Route::get('search_mrs_no', [ScmMirController::class, 'searchMrs'])->name('search_mrs_no');
Route::get('search-type-no', [ScmMirController::class, 'searchTypeNo'])->name('searchTypeNo');
Route::get('search-mrs--type-wise-aterials', [ScmMirController::class, 'mrsAndTypeWiseMaterials'])->name('mrsAndTypeWiseMaterials');
Route::get('getMaterialStock', [ScmMirController::class, 'getMaterialStock'])->name('getMaterialStock');

Route::resources([
    'material-issues' => ScmMirController::class,
    'gate-passes' => ScmGatePassController::class,
]);
