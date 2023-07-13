<?php


use Illuminate\Support\Facades\Route;
use Modules\Networking\Http\Controllers\VasServiceController;
use Modules\Networking\Http\Controllers\PhysicalConnectivityController;
use Modules\Networking\Http\Controllers\LogicalConnectivityDataController;
use Modules\Networking\Http\Controllers\LogicalConnectivityVasController;

Route::resources([
    'physical-connectivities' => PhysicalConnectivityController::class,
    'logical-internet-connectivities' => LogicalConnectivityDataController::class,
    'logical-data-connectivities' => LogicalConnectivityDataController::class,
    'logical-vas-connectivities' => LogicalConnectivityVasController::class,
    'vas-services' => VasServiceController::class,
]);
Route::get('get-network-info-by-fr', [PhysicalConnectivityController::class, 'getNetworkInfoByFr'])->name('getNetworkInfoByFr');
Route::get('get-challan-by-link-no', [PhysicalConnectivityController::class, 'getChallanInfoByLinkNo'])->name('getChallanInfoByLinkNo');
Route::get('get-challan-info-by-challan-no', [PhysicalConnectivityController::class, 'getChallanInfoByChallanNo'])->name('getChallanInfoByChallanNo');
