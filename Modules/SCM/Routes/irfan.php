<?php


use Illuminate\Support\Facades\Route;
use Modules\SCM\Http\Controllers\ScmMrrController;

Route::resources([
    'material-receives' => ScmMrrController::class,
]);

Route::get('search_po_with_date', [ScmMrrController::class, 'searchPoWithDate'])->name('search_po_with_date');
Route::get('get_materials_for_po/{po_no}', [ScmMrrController::class, 'getMaterialForPo'])->name('get_materials_for_po');
Route::get('get_unit/{material_id}', [ScmMrrController::class, 'getUnit'])->name('get_unit');
