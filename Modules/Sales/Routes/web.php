<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\LeadGenerationController;
use Modules\Sales\Http\Controllers\MeetingController;
use Modules\Sales\Http\Controllers\FollowUpController;
use Modules\Sales\Http\Controllers\CategoryController;
use Modules\Sales\Http\Controllers\ProductController;
use Modules\Sales\Http\Controllers\FeasibilityRequirementController;
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
    ]);
    Route::get('followup/create/{meeting_id?}', [FollowUpController::class, 'create'])->name('followup.create');
    Route::get('get-client', [LeadGenerationController::class, 'getClient'])->name('get-client');
    Route::get('delete-feasibility-requirement-detail', [FeasibilityRequirementController::class, 'deleteFeasibilityRequirementDetail'])->name('delete-feasibility-requirement-details');
    
});
