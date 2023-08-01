<?php

// use App\Http\Controllers\Dataencoding\AuthController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControllerCopy;
use App\Http\Controllers\CommonApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientFeedbackController;
use Modules\Admin\Http\Controllers\AuthController;
use Modules\SCM\Http\Controllers\ScmErrController;

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

Route::get('/welcome', function () {
    return view('welcome');
});
// Route::get('/login', [AuthController::class, 'login'])->name('login');

// Route::get('/password-change-config', 'Auth\ResetOldPasswordController@PasswordResetForm')->name('password-change-form');
// Route::post('/password-change', 'Auth\ResetOldPasswordController@ResetPassword')->name('password-change');
// Route::resource('users', UserControllerCopy::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('search-client', [CommonApiController::class, 'searchClient'])->name('searchClient');
    Route::get('search-client-with-fr-details', [CommonApiController::class, 'searchClientWithFrDetails'])->name('searchClientWithFrDetails');
    Route::get('get-fr-details-data', [CommonApiController::class, 'getFrDetailsData'])->name('getFrDetailsData');
    Route::get('search-material', [CommonApiController::class, 'searchMaterial'])->name('searchMaterial');
    Route::get('search-branch', [CommonApiController::class, 'searchBranch'])->name('searchBranch');
    Route::get('search-pop', [CommonApiController::class, 'searchPop'])->name('searchPop');
    Route::get('search-pop-by-branch-id', [CommonApiController::class, 'searchPopByBranchId'])->name('searchPopByBranchId');
    Route::get('search-pop-by-branch', [CommonApiController::class, 'searchPopByBranch'])->name('searchPopByBranch');
    Route::get('search-brand', [CommonApiController::class, 'searchBrand'])->name('searchBrand');
    Route::get('search-department', [CommonApiController::class, 'searchDepartment'])->name('searchDepartment');
    Route::get('search-employee', [CommonApiController::class, 'searchEmployee'])->name('searchEmployee');
    Route::get('search-supplier', [CommonApiController::class, 'searchSupplier'])->name('searchSupplier');
    Route::get('search-user', [CommonApiController::class, 'searchUser'])->name('searchUser');
    Route::get('get-districts', [CommonApiController::class, 'getDistricts'])->name('get-districts');
    Route::get('get-thanas', [CommonApiController::class, 'getThanas'])->name('get-thanas');
    Route::get('search-prs-no', [CommonApiController::class, 'searchPrsNo'])->name('searchPrsNo');
    Route::get('get-clients-by-links', [CommonApiController::class, 'getClientsByLinkId'])->name('get-clients-by-links');
    Route::get('get-clients-previous-tickets/{clientId}/{limit}', [CommonApiController::class, 'getClientsPreviousTickets'])->name('get-clients-previous-tickets');
    Route::get('get-support-team-members', [CommonApiController::class, 'getSupportTeamMembers'])->name('get-support-team-members');
    Route::get('search-indent-no', [CommonApiController::class, 'searchIndentNo'])->name('searchIndentNo');
    Route::get('search-cs-no/{supplierId}', [CommonApiController::class, 'searchCsNo'])->name('searchCsNo');
    Route::get('search-support-ticket', [CommonApiController::class, 'getSupportTicket'])->name('search-support-ticket');
    Route::get('search-link-no', [CommonApiController::class, 'getLinkNo'])->name('getLinkNo');

    Route::get('all-notifications', [DashboardController::class, 'allNotifications'])->name('all-notifications');
    Route::get('read-all-notification', [DashboardController::class, 'readAllNotification'])->name('read-all-notification');

    Route::get('provide-feedback/{slug}', [ClientFeedbackController::class, 'provideFeedback'])->name('provide-feedback');
    Route::post('store-client-feedback/{slug}', [ClientFeedbackController::class, 'storeClientFeedback'])->name('store-client-feedback');

    Route::get('search-ip', [CommonApiController::class, 'searchIp'])->name('searchIp');
    Route::get('get-links-by-fr/{client_id}/{fr_no}', [CommonApiController::class, 'getLinksByFr'])->name('get-links-by-fr');
    Route::get('search-vendor', [CommonApiController::class, 'searchVendor'])->name('searchVendor');
});

require base_path('routes/dataencoding.php');

require base_path('routes/sales.php');
require base_path('routes/feasibility.php');
require base_path('routes/scm.php');
require base_path('routes/ticketing.php');
require base_path('routes/billing.php');
