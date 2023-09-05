<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillGenerateController;
use Modules\Networking\Http\Controllers\NetworkingController;
use Modules\Billing\Http\Controllers\BrokenDaysBillController;
use Modules\Networking\Http\Controllers\ConnectivityController;
use Modules\Networking\Http\Controllers\NetPopEquipmentController;
use Modules\Networking\Http\Controllers\PhysicalConnectivityController;

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

Route::prefix('networking')->middleware(['auth'])->group(function () {
    Route::get('/', 'NetworkingController@index');
    Route::get('get-pop-equipments', [NetPopEquipmentController::class, 'getPopEquipments'])->name('getPopEquipments');
    Route::get('connectivity-list', [NetworkingController::class, 'connectivityList'])->name('connectivity-list');

    Route::get('connectivities/create/{fr_id?}', [ConnectivityController::class, 'create'])->name('connectivities.create');
    Route::post('connectivities-billing-date-update', [BrokenDaysBillController::class, 'updateBillingDate'])->name('connectivities.billing.date.update');
    // Route::get('add-survey/{fr_id?}', [SurveyController::class, 'create'])->name('add-survey');

    Route::resource('connectivities', ConnectivityController::class);
    require __DIR__ . '/irfan.php';
    require __DIR__ . '/jaber.php';
});
