<?php


use Illuminate\Support\Facades\Route;
use Modules\Networking\Http\Controllers\DataTypeController;
use Modules\Networking\Http\Controllers\CCScheduleController;
use Modules\Networking\Http\Controllers\VasServiceController;
use Modules\Networking\Http\Controllers\PhysicalConnectivityController;
use Modules\Networking\Http\Controllers\LogicalConnectivityVasController;
use Modules\Networking\Http\Controllers\LogicalConnectivityDataController;
use Modules\Networking\Http\Controllers\LogicalConnectivityInternetController;

Route::resources([
    'physical-connectivities' => PhysicalConnectivityController::class,
    'logical-internet-connectivities' => LogicalConnectivityDataController::class,
    'logical-data-connectivities' => LogicalConnectivityDataController::class,
    'logical-vas-connectivities' => LogicalConnectivityVasController::class,
    'logical-internet-connectivities' => LogicalConnectivityInternetController::class,
    'vas-services' => VasServiceController::class,
    'data-types' => DataTypeController::class,
    'cc-schedules' => CCScheduleController::class,
]);
Route::get('get-network-info-by-fr', [PhysicalConnectivityController::class, 'getNetworkInfoByFr'])->name('getNetworkInfoByFr');
Route::get('get-challan-by-link-no', [PhysicalConnectivityController::class, 'getChallanInfoByLinkNo'])->name('getChallanInfoByLinkNo');
Route::get('get-challan-info-by-challan-no', [PhysicalConnectivityController::class, 'getChallanInfoByChallanNo'])->name('getChallanInfoByChallanNo');
// Route::get('activation-preprocesses', [CCScheduleController::class, 'index'])->name('activation-preprocesses.index');
