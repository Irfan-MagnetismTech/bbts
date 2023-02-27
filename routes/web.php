<?php

// use App\Http\Controllers\Dataencoding\AuthController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControllerCopy;
use App\Http\Controllers\CommonApiController;
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
Route::middleware(['auth'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('search-client', [CommonApiController::class, 'searchClient'])->name('searchClient');
    Route::get('search-material', [CommonApiController::class, 'searchMaterial'])->name('searchMaterial');
    Route::get('search-branch', [CommonApiController::class, 'searchBranch'])->name('searchBranch');
    Route::get('search-pop', [CommonApiController::class, 'searchPop'])->name('searchPop');
    Route::get('search-brand', [CommonApiController::class, 'searchBrand'])->name('searchBrand');
    Route::get('search-department', [CommonApiController::class, 'searchDepartment'])->name('searchDepartment');
    Route::get('search-employee', [CommonApiController::class, 'searchEmployee'])->name('searchEmployee');
    Route::post('search-supplier', [CommonApiController::class, 'searchSupplier'])->name('searchSupplier');
    Route::get('search-user', [CommonApiController::class, 'searchUser'])->name('searchUser');
    Route::get('get-districts', [CommonApiController::class, 'getDistricts'])->name('get-districts');
    Route::get('get-thanas', [CommonApiController::class, 'getThanas'])->name('get-thanas');
    Route::get('search-prs-no', [CommonApiController::class, 'searchPrsNo'])->name('searchPrsNo');
    Route::get('get-clients-by-links', [CommonApiController::class, 'getClientsByLinkId'])->name('get-clients-by-links');
});

require base_path('routes/dataencoding.php');

require base_path('routes/sales.php');
require base_path('routes/feasibility.php');
require base_path('routes/scm.php');
require base_path('routes/ticketing.php');
require base_path('routes/billing.php');
