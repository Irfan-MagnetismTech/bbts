<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillGenerateController;
use Modules\Networking\Http\Controllers\ConnectivityModificationController;
use Modules\Networking\Http\Controllers\NetworkingController;
use Modules\Billing\Http\Controllers\BrokenDaysBillController;
use Modules\Networking\Http\Controllers\ConnectivityController;
use Modules\Networking\Http\Controllers\ImportController;
use Modules\Networking\Http\Controllers\NetPopEquipmentController;
use Modules\Networking\Http\Controllers\LogicalConnectivityController;
use Modules\Networking\Http\Controllers\PhysicalConnectivityModificationController;
use Modules\Networking\Http\Requests\ConnectivityRequest;
use Modules\Sales\Http\Controllers\ConnectivityRequirementController;

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


    // Route::get('ip-import', [ImportController::class, 'ip_import'])->name('ip-import');
    Route::get('active-clients-report', [ConnectivityController::class, 'activeClientsReport'])->name('active-clients-report');
    Route::get('active-clients-report-details/{fr_id?}', [ConnectivityController::class, 'activeClientsReportDetails'])->name('active-clients-report-details');
    Route::get('ip-report', [ConnectivityController::class, 'ipReport'])->name('ip-report');
    Route::get('vlan-report', [ConnectivityController::class, 'vlanReport'])->name('vlan-report');

    Route::resource('connectivities', ConnectivityController::class);
    Route::resource('logical-connectivities', LogicalConnectivityController::class);
    Route::get('modify-connectivities/create/{fr_id?}', [ConnectivityModificationController::class, 'create'])->name('connectivities.create');
    Route::resource('modify-connectivities', ConnectivityModificationController::class);
    Route::get('pop-wise-client-report', [ConnectivityController::class, 'popWiseClientReport'])->name('pop-wise-client-report');
    Route::get('pop-wise-equipment-report', [ConnectivityController::class, 'popWiseEquipmentReport'])->name('pop-wise-equipment-report');
    Route::get('client-wise-equipment-report', [ConnectivityController::class, 'clientWiseEquipmentReport'])->name('client-wise-equipment-report');
    Route::get('client-wise-net-ip-report', [ConnectivityController::class, 'clientWiseNetIpReport'])->name('client-wise-net-ip-report');
    Route::get('permanently-inactive-clients', [ConnectivityController::class, 'permanentlyInactiveClients'])->name('permanently-inactive-clients');
    Route::get('account-holder-wise-inactive-report', [ConnectivityController::class, 'accountHolderWiseInactiveReport'])->name('account-holder-wise-inactive-report');
    Route::get('branch-wise-inactive-report', [ConnectivityController::class, 'branchWiseInactiveReport'])->name('branch-wise-inactive-report');
    require __DIR__ . '/irfan.php';
    require __DIR__ . '/jaber.php';
});
