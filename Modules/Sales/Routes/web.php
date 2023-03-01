<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\LeadGenerationController;
use Modules\Sales\Http\Controllers\MeetingController;
use Modules\Sales\Http\Controllers\FollowUpController;
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
    ]);
    Route::resources([
        'meeting' => MeetingController::class,
    ]);
    Route::resources([
        'followup' => FollowUpController::class,
    ]);
    Route::get('followup/create/{meeting_id?}', [FollowUpController::class, 'create'])->name('followup.create');
});
