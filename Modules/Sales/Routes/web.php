<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Http\Controllers\LeadGenerationController;
use Modules\Sales\Http\Controllers\MeetingController;
use Modules\Sales\Http\Controllers\FollowUpController;
use Modules\Sales\Http\Controllers\CategoryController;
use Modules\Sales\Http\Controllers\ConnectivityRequirementController;
use Modules\Sales\Http\Controllers\ProductController;
use Modules\Sales\Http\Controllers\FeasibilityRequirementController;
use Modules\Sales\Http\Controllers\ServeyController;
use Modules\Sales\Http\Controllers\VendorController;
use Modules\Sales\Http\Controllers\PlanningController;

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

Route::prefix('sales')->group(function () {
    Route::resources([
        'lead-generation' => LeadGenerationController::class,
        'meeting' => MeetingController::class,
        'followup' => FollowUpController::class,
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'feasibility-requirement' => FeasibilityRequirementController::class,
        'connectivity-requirement' => ConnectivityRequirementController::class,
        'survey' => ServeyController::class,
        'vendor' => VendorController::class,
        'planning' => PlanningController::class,
    ]);
    Route::get('followup/create/{meeting_id?}', [FollowUpController::class, 'create'])->name('followup.create');
    Route::get('get-client', [LeadGenerationController::class, 'getClient'])->name('get-client');
    Route::get('delete-feasibility-requirement-detail', [FeasibilityRequirementController::class, 'deleteFeasibilityRequirementDetail'])->name('delete-feasibility-requirement-details');
    Route::get('connectivity-requirement-add/{fr_id?}', [ConnectivityRequirementController::class, 'create'])->name('connectivity-requirement-add');
    Route::get('delete-product-requirement-details', [ConnectivityRequirementController::class, 'deleteProductRequirementDetails'])->name('delete-product-requirement-details');
    Route::get('delete-connectivity-requirement-details', [ConnectivityRequirementController::class, 'deleteConnectivityRequirementDetails'])->name('delete-connectivity-requirement-details');
    Route::get('get-products', [ProductController::class, 'getProducts'])->name('get-products');
    Route::get('add-survey/{fr_id?}', [ServeyController::class, 'create'])->name('add-survey');
});
