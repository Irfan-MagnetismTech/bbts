<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\LeadGenerationController;
use Modules\Sales\Http\Controllers\MeetingController;
use Modules\Sales\Http\Controllers\FollowUpController;
use Modules\Sales\Http\Controllers\CategoryController;
use Modules\Sales\Http\Controllers\ConnectivityRequirementController;
use Modules\Sales\Http\Controllers\ProductController;
use Modules\Sales\Http\Controllers\FeasibilityRequirementController;
use Modules\Sales\Http\Controllers\SurveyController;
use Modules\Sales\Http\Controllers\VendorController;
use Modules\Sales\Http\Controllers\PlanningController;
use Modules\Sales\Http\Controllers\SaleController;
use Modules\Sales\Http\Controllers\ClientProfileController;
use Modules\Sales\Http\Controllers\CommonController;
use Modules\Sales\Http\Controllers\CostingController;
use Modules\Sales\Http\Controllers\OfferController;

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

Route::prefix('sales')->middleware(['auth'])->group(function () {
    require __DIR__ . '/jaber.php';
    require __DIR__ . '/irfan.php';
    require __DIR__ . '/saiful.php';

    Route::resources([
        'lead-generation' => LeadGenerationController::class,
        'meeting' => MeetingController::class,
        'followup' => FollowUpController::class,
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'feasibility-requirement' => FeasibilityRequirementController::class,
        'connectivity-requirement' => ConnectivityRequirementController::class,
        'survey' => SurveyController::class,
        'vendor' => VendorController::class,
        'planning' => PlanningController::class,
        'client-profile' => ClientProfileController::class,
        'costing' => CostingController::class,
        'offer' => OfferController::class,
    ]);
    Route::get('followup/create/{meeting_id?}', [FollowUpController::class, 'create'])->name('followup.create');
    Route::get('get-client', [LeadGenerationController::class, 'getClient'])->name('get-client');
    Route::get('get-client-information-for-profile', [LeadGenerationController::class, 'getClientInformationForProfile'])->name('get-client-information-for-profile');
    Route::get('delete-feasibility-requirement-detail', [FeasibilityRequirementController::class, 'deleteFeasibilityRequirementDetail'])->name('delete-feasibility-requirement-details');
    Route::get('connectivity-requirement-add/{fr_id?}', [ConnectivityRequirementController::class, 'create'])->name('connectivity-requirement-add');
    Route::get('delete-product-requirement-details', [ConnectivityRequirementController::class, 'deleteProductRequirementDetails'])->name('delete-product-requirement-details');
    Route::get('delete-connectivity-requirement-details', [ConnectivityRequirementController::class, 'deleteConnectivityRequirementDetails'])->name('delete-connectivity-requirement-details');
    Route::get('get-products', [ProductController::class, 'getProducts'])->name('get-products');
    Route::get('add-survey/{fr_id?}', [SurveyController::class, 'create'])->name('add-survey');
    Route::get('get-client-fr-list', [FeasibilityRequirementController::class, 'getClientFrList'])->name('get-client-fr-list');
    Route::get('get-survey-details-list', [SurveyController::class, 'getSurveyDetailsList'])->name('get-survey-details');
    Route::get('final-survey-details', [SurveyController::class, 'finalSurveyDetailsList'])->name('final-survey-details-list');
    Route::get('final-survey-details/{id}', [SurveyController::class, 'finalSurveyDetailsShow'])->name('final-survey-details-show');
    // Route::get('sales-dashboard', [SalesController::class, 'salesDashboard'])->name('sales-dashboard');
    // Route::get('sales-admin-dashboard', [SalesController::class, 'salesAdminDashboard'])->name('sales-admin-dashboard');
    Route::get('lead-generation-update-status/{id}', [LeadGenerationController::class, 'updateStatus'])->name('lead-generation.status.update');
    Route::get('meeting-status-update/{id}', [MeetingController::class, 'updateStatus'])->name('meeting.status.update');
    Route::get('add-planning/{id}', [PlanningController::class, 'create'])->name('add-planning');
    Route::get('add-costing/{id}', [CostingController::class, 'create'])->name('add-costing');
    Route::get('client-wise-mq/{id}', [OfferController::class, 'clientWiseMq'])->name('client-wise-mq');
    Route::get('add-offer/{id}', [OfferController::class, 'create'])->name('add-offer');
    Route::get('pnl-summary/{id?}', [SaleController::class, 'pnlSummary'])->name('pnl-summary');
    Route::get('pnl-details/{id?}', [SaleController::class, 'pnlDetails'])->name('pnl-details');
    Route::get('pnl-approve-by-finance/{mq_no}', [SaleController::class, 'pnlApproveByFinance'])->name('pnl-approve-by-finance');
    Route::get('pnl-approve-by-cmo/{mq_no}', [SaleController::class, 'pnlApproveByCmo'])->name('pnl-approve-by-cmo');
    Route::get('pnl-approve-by-management/{mq_no}', [SaleController::class, 'pnlApproveByManagement'])->name('pnl-approve-by-management');
    Route::get('client-offer/{mq_no}', [SaleController::class, 'clientOffer'])->name('client-offer');
    Route::get('get-pop-details', [CommonController::class, 'getPopDetails'])->name('get-pop-details');
    Route::get('get-existing-link-list', [CommonController::class, 'getExistingLinkList'])->name('get-existing-link-list');
});
