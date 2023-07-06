<?php

use Illuminate\Support\Facades\Route;
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
    require __DIR__ . '/irfan.php';
    require __DIR__ . '/jaber.php';
});
