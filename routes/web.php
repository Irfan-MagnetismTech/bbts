<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/password-change-config', 'Auth\ResetOldPasswordController@PasswordResetForm')->name('password-change-form');
Route::post('/password-change', 'Auth\ResetOldPasswordController@ResetPassword')->name('password-change');
Route::resource('users', UserController::class);

require base_path('routes/dataencoding.php');
