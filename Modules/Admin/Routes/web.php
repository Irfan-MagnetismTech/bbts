<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\PopController;
use Modules\Admin\Http\Controllers\AuthController;
use Modules\Admin\Http\Controllers\RoleController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Controllers\BrandController;
use Modules\Admin\Http\Controllers\BranchController;
use Modules\Admin\Http\Controllers\PermissionController;

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
        Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
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
        ]);
    });

    Route::get('get_districts', [BranchController::class, 'getDistricts'])->name('get_districts');
    Route::get('get_thanas', [BranchController::class, 'getThanas'])->name('get_thanas');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
