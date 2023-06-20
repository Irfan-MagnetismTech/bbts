<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Admin\Http\Controllers\PopController;
use Modules\Admin\Http\Controllers\AuthController;
use Modules\Admin\Http\Controllers\BankController;
use Modules\Admin\Http\Controllers\RoleController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Controllers\ZoneController;
use Modules\Admin\Http\Controllers\BrandController;
use Modules\Admin\Http\Controllers\BranchController;
use Modules\Admin\Http\Controllers\ServiceController;
use Modules\Admin\Http\Controllers\ParticularController;
use Modules\Admin\Http\Controllers\PermissionController;
use Modules\Admin\Http\Controllers\ConnectivityLinkController;

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

Route::prefix('admin')->group(function () {

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/password-change-config', [AuthController::class, 'passwordResetForm'])->name('password-change-form');
        Route::post('/password-change', [AuthController::class, 'resetPassword'])->name('password-change');

        Route::resources([
            'roles'         => RoleController::class,
            'permissions'   => PermissionController::class,
            'users'         => UserController::class,
            'brands'        => BrandController::class,
            'branchs'       => BranchController::class,
            'pops'          => PopController::class,
            'connectivity'  => ConnectivityLinkController::class,
            'particulars'   => ParticularController::class,
            'banks'         => BankController::class,
            'services'      => ServiceController::class,
            'zones'         => ZoneController::class,
        ]);
    });

    Route::get('get_districts', [BranchController::class, 'getDistricts'])->name('get_districts');
    Route::get('get_thanas', [BranchController::class, 'getThanas'])->name('get_thanas');
    Route::get('get_vendors', [ConnectivityLinkController::class, 'getVendors'])->name('get_vendors');
    Route::get('get_pops', [ConnectivityLinkController::class, 'getPop'])->name('get_pops');
    Route::get('get_link_sites', [ConnectivityLinkController::class, 'getLinkSite'])->name('get_link_sites');
    Route::get('get_location_info_for_link', [ConnectivityLinkController::class, 'getLocationInfoForLink'])->name('get_location_info_for_link');
    Route::get('get_connectivity_link_log/{link_name}', [ConnectivityLinkController::class, 'getConnectivityLinkLog'])->name('get_connectivity_link_log');

    Route::get('get-bbts-link-id', [ServiceController::class, 'get_bbts_link_id'])->name('get_bbts_link_id');
    Route::get('get-existing-services', [ServiceController::class, 'existingServices'])->name('existingServices');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
