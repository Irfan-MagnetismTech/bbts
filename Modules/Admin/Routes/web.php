<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\RoleController;
use Modules\Admin\Http\Controllers\UnitController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Controllers\BrandController;
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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index');
    Route::resources([
        'roles'         => RoleController::class,
        'permissions'   => PermissionController::class,
        'users'         => UserController::class,
        'units'         => UnitController::class,
        'brands'        => BrandController::class,
    ]);
});
