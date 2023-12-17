<?php

use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\ScmGatePassController;
use Modules\SCM\Http\Controllers\ScmMrrController;
use Modules\SCM\Http\Controllers\ScmReportController;
use Modules\SCM\Http\Controllers\ScmWcrController;
use Modules\SCM\Http\Controllers\UnitController;
use Modules\SCM\Http\Controllers\CourierController;
use Modules\SCM\Http\Controllers\CsController;
use Modules\SCM\Http\Controllers\IndentController;
use Modules\SCM\Http\Controllers\MaterialController;
use Modules\SCM\Http\Controllers\PurchaseOrderController;
use Modules\SCM\Http\Controllers\ScCategoryController;
use Modules\SCM\Http\Controllers\ScmPurchaseRequisitionController;
use Modules\SCM\Http\Controllers\SupplierController;
use Modules\SCM\Http\Controllers\ScmRequisitionController;
use Modules\SCM\Http\Controllers\ScmChallanController;
use Modules\SCM\Http\Controllers\OpeningStockController;
use Modules\SCM\Http\Controllers\ScmMurController;

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
        'opening-stocks'            => OpeningStockController::class,
        'cs'                        => CsController::class,
        'indents'                   => IndentController::class,
        'purchase-orders'           => PurchaseOrderController::class,
        'sc-categories'             => ScCategoryController::class,
    ]);
    // Route::get('search-material-by-cs-requisition/{csId}', [PurchaseOrderController::class, 'searchMaterialByCsAndRequsiition'])->name('search-material-by-cs-requisition');


    Route::get('mur-approval/{scmMur}', [ScmMurController::class, 'murApproval'])->name('mur-approval');


    Route::get('search-material-by-indent', [CsController::class, 'searchMaterialByIndent'])->name('search-material-by-indent');
    Route::get('search-material-by-cs-requisition', [PurchaseOrderController::class, 'searchMaterialByCsAndRequsiition'])->name('search-material-by-cs-requisition');
    Route::get('get-unique-code', [MaterialController::class, 'getUniqueCode'])->name('get-unique-code');
    Route::get('cs-pdf/{id}', [CsController::class, 'generateCsPdf'])->name('cs-pdf');
    Route::get('get-indent-no', [CsController::class, 'getIndentNo'])->name('get-indent-no');
    Route::get('gate-pass/{id}', [ScmGatePassController::class, 'pdf'])->name('gate-pass');
    Route::get('po-pdf/{id}', [PurchaseOrderController::class, 'pdf'])->name('po-pdf');
    Route::get('indent-pdf/{id}', [IndentController::class, 'pdf'])->name('indent-pdf');
    Route::get('challan-pdf/{id}', [ScmChallanController::class, 'challanPdf'])->name('challan-pdf');
    Route::get('challan-gate-pass/{id}', [ScmChallanController::class, 'gatePassPdf'])->name('challan-gate-pass');
    Route::get('wcr-gate-pass/{id}', [ScmWcrController::class, 'gatePassPdf'])->name('wcr-gate-pass');
    Route::get('find-supplier', [PurchaseOrderController::class, 'findSupplier'])->name('findSupplier');
    Route::get('find-indent-no', [PurchaseOrderController::class, 'findIndentNo'])->name('findIndentNo');
    Route::get('close-po/{id}', [PurchaseOrderController::class, 'closePo'])->name('closePo');
    Route::get('search_bill_reg_no', [ScmMrrController::class, 'searchBillRegisterNoWithDate'])->name('searchBillRegisterNoWithDate');
    Route::get('search_mrs_for_challan', [ScmChallanController::class, 'searchMrs'])->name('search_mrs_for_challan');
    Route::get('scm-material-stock-report', [ScmReportController::class, 'materialStockReport'])->name('scm-material-stock-report');
    Route::get('scm-item-report', [ScmReportController::class, 'scmItemReport'])->name('scm-item-report');
    Route::get('scm-report', [ScmReportController::class, 'scmReport'])->name('scm-report');
    Route::get('search-indent-prs-no', [IndentController::class, 'searchIndentPrsNo'])->name('searchIndentPrsNo');
    require __DIR__ . '/jaber.php';
    require __DIR__ . '/irfan.php';
});
