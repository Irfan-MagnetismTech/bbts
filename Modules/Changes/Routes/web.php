<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\OfferController;
use Modules\Sales\Http\Controllers\CostingController;
use Modules\Sales\Http\Controllers\PlanningController;
use Modules\Changes\Http\Controllers\ModifiedSurveyController;
use Modules\Changes\Http\Controllers\ClientRequirementController;
use Modules\Changes\Http\Controllers\ClientPlanningModificationController;
use Modules\Changes\Http\Controllers\CostingModificationController;
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
    Route::get('/', 'ChangesController@index');
    Route::resources([
        'client-requirement-modification' => ClientRequirementController::class,
        'client-plan-modification' => ClientPlanningModificationController::class,
        'costing-modification' => CostingModificationController::class,
    ]);
    Route::get('add-modified-survey/{fr_id?}', [ModifiedSurveyController::class, 'create'])->name('add-modified-survey');
    // Route::get('add-modified-planning/{id}', [PlanningController::class, 'create'])->name('add-modified-planning');
    // Route::get('add-modified-costing/{id}', [CostingController::class, 'create'])->name('add-modified-costing');
    // Route::get('add-modified-offer/{id}', [OfferController::class, 'create'])->name('add-modified-offer');
    Route::get('client-plan-modification/{connectivity_requirement_id}/create', [ClientPlanningModificationController::class, 'create'])->name('client-requirement-modification.create');
    Route::get('get-modify-survey-details', [ClientPlanningModificationController::class, 'getModifySurveyDetails'])->name('get-modify-survey-details');
    Route::get('costing-modification/{fr_no}/create', [CostingModificationController::class, 'create'])->name('costing-modification.create');
});
