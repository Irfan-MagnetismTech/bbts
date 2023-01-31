<?php

// use App\Http\Controllers\Dataencoding\AuthController;
use App\Http\Controllers\UserControllerCopy;
// use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AuthController;

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

//Route::get('/', function () {
//    return view('welcome');
//});
// Route::get('/login', [AuthController::class, 'login'])->name('login');

// Route::get('/password-change-config', 'Auth\ResetOldPasswordController@PasswordResetForm')->name('password-change-form');
// Route::post('/password-change', 'Auth\ResetOldPasswordController@ResetPassword')->name('password-change');
// Route::resource('users', UserControllerCopy::class);
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
require base_path('routes/dataencoding.php');

require base_path('routes/sales.php');
require base_path('routes/feasibility.php');
require base_path('routes/scm.php');
require base_path('routes/ticketing.php');
require base_path('routes/billing.php');

