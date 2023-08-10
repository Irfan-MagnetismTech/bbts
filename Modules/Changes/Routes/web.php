<?php

use Illuminate\Support\Facades\Route;
use Modules\Changes\Http\Controllers\ClientRequirementController;
use Modules\Changes\Http\Controllers\ClientPlanningModificationController;
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
    ]);
});
