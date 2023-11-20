<?php

namespace Modules\Changes;

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\OfferController;
use Modules\Sales\Http\Controllers\CostingController;
use Modules\Sales\Http\Controllers\PlanningController;
use Modules\Changes\Http\Controllers\ModifiedSurveyController;
use Modules\Changes\Http\Controllers\ClientRequirementController;
use Modules\Changes\Http\Controllers\ClientPlanningModificationController;
use Modules\Changes\Http\Controllers\CostingModificationController;
use Modules\Changes\Http\Controllers\OfferModificationController;
use Modules\Changes\Http\Controllers\SaleModificationController;
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

Route::prefix('changes')->middleware(['auth'])->group(function () {
    // Route::get('/', 'ChangesController@index');
    Route::resources([
        'client-requirement-modification' => ClientRequirementController::class,
        'client-plan-modification' => ClientPlanningModificationController::class,
        'costing-modification' => CostingModificationController::class,
        'survey-modification' => ModifiedSurveyController::class,
        'sales-modification' => SaleModificationController::class,
        'offer-modification' => OfferModificationController::class,
    ]);
    Route::get('add-modified-survey/{fr_id?}', [ModifiedSurveyController::class, 'create'])->name('add-modified-survey');
    Route::get('add-modified-planning/{id}', [PlanningController::class, 'create'])->name('add-modified-planning');
    Route::get('add-modified-costing/{id}', [CostingController::class, 'create'])->name('add-modified-costing');
    Route::get('add-modified-offer/{connectivity_requirement_id}/create', [OfferModificationController::class, 'create'])->name('add-modified-offer');
    Route::get('client-plan-modification/{connectivity_requirement_id}/create', [ClientPlanningModificationController::class, 'create'])->name('client-requirement-modification.create');
    Route::get('get-modify-survey-details', [ClientPlanningModificationController::class, 'getModifySurveyDetails'])->name('get-modify-survey-details');
    Route::get('costing-modification/{connectivity_requirement_id}/create', [CostingModificationController::class, 'create'])->name('costing-modification.create');
    Route::get('get-option-for-survey/{connectivity_requirement_id}', [ModifiedSurveyController::class, 'getOptionForSurvey'])->name('getOptionForSurvey');
    Route::get('get-client-info-for-sales-modification-fr', [SaleModificationController::class, 'getClientInfoForSalesModificationFR'])->name('get-client-info-for-sales-modification-fr');
    Route::get('get-sale-modication-fr-details', [SaleModificationController::class, 'getSaleModicationFRDetails'])->name('get-sale-modication-fr-details');
    Route::get('sales-modification/{connectivity_requirement_id}/create', [SaleModificationController::class, 'create'])->name('sales-modification.create');
    Route::get('get-fr-wise-pnl-report/{fr_no}', [SaleModificationController::class, 'getFrWisePnlReport'])->name('get-fr-wise-pnl-report');
    Route::get('get-client-info-for-sale-modification', [SaleModificationController::class, 'getClientInfoForSales'])->name('get-client-info-for-sale-modification');
    Route::get('modify-pnl-summary/{id?}', [SaleModificationController::class, 'pnlSummary'])->name('modify-pnl-summary');
    Route::get('modify-pnl-details/{id?}', [SaleModificationController::class, 'pnlDetails'])->name('modify-pnl-details');
    Route::get('modify-pnl-approve-by-finance/{connectivity_requirement_id}', [SaleModificationController::class, 'pnlApproveByFinance'])->name('modify-pnl-approve-by-finance');
    Route::get('modify-pnl-approve-by-cmo/{connectivity_requirement_id}', [SaleModificationController::class, 'pnlApproveByCmo'])->name('modify-pnl-approve-by-cmo');
    Route::get('modify-pnl-approve-by-management/{connectivity_requirement_id}', [SaleModificationController::class, 'pnlApproveByManagement'])->name('modify-pnl-approve-by-management');
    Route::get('search-client', [ClientRequirementController::class, 'searchClient'])->name('searchClient');
});
