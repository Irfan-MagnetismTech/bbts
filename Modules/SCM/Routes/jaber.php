<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\ScmErrController;
use Modules\SCM\Http\Controllers\ScmMirController;
use Modules\SCM\Http\Controllers\WorkOrderController;
use Modules\SCM\Http\Controllers\ScmGatePassController;
use Modules\SCM\Http\Controllers\PurchaseOrderController;
use Modules\SCM\Http\Controllers\ScmWorController;

Route::get('search-material-brand-by-cs-requisition/{csId}/{supplierId}/{materialId}', [PurchaseOrderController::class, 'searchMaterialBrandByCsAndRequsiition'])->name('search-material-brand-by-cs-requisition');
Route::get('get-material-by-cs/{csId}/{supplier_id}', [PurchaseOrderController::class, 'getMaterialByCS'])->name('get-material-by-cs');
Route::get('search_mrs_no', [ScmMirController::class, 'searchMrs'])->name('search_mrs_no');
Route::get('search-type-no', [ScmMirController::class, 'searchTypeNo'])->name('searchTypeNo');
Route::get('search-mrs-type-wise-aterials', [ScmMirController::class, 'mrsAndTypeWiseMaterials'])->name('mrsAndTypeWiseMaterials');
Route::get('search-mrs-type-wise-material-for-challan', [ScmMirController::class, 'mrsAndTypeWiseMaterialsForChallan'])->name('search-mrs-type-wise-material-for-challan');
Route::get('search-materialwise-brand', [ScmMirController::class, 'materialWiseBrands'])->name('materialWiseBrands');
Route::get('search-brandwise-model', [ScmMirController::class, 'brandWiseModels'])->name('brandWiseModels');
Route::get('search-model-wise-serial-code', [ScmMirController::class, 'modelWiseSerialCodes'])->name('modelWiseSerialCodes');
Route::get('getMaterialStock', [ScmMirController::class, 'getMaterialStock'])->name('getMaterialStock');
Route::get('get-stock', [ScmMirController::class, 'getChallanMaterialStock'])->name('get-stock');
Route::get('get-from-and-to-branch-stock', [ScmMirController::class, 'getFromAndToBranchStock'])->name('get-from-and-to-branch-stock');
Route::get('clientMurWiseMaterials', [ScmErrController::class, 'clientMurWiseMaterials'])->name('clientMurWiseMaterials');
Route::get('search-serial-for-wor', [ScmWorController::class, 'searchSerialForWor'])->name('searchSerialForWor');

Route::resources([
    'material-issues' => ScmMirController::class,
    'gate-passes' => ScmGatePassController::class,
    'errs' => ScmErrController::class,
    'work-order-receives' => ScmWorController::class,
]);
