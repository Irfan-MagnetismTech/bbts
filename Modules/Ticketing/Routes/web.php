<?php
use Illuminate\Support\Facades\Route;
use Modules\Ticketing\Entities\TicketSource;
use Modules\Ticketing\Http\Controllers\SupportTeamController;
use Modules\Ticketing\Http\Controllers\TicketSourceController;
use Modules\Ticketing\Http\Controllers\SupportTicketController;
use Modules\Ticketing\Http\Controllers\SupportComplainTypeController;
use Modules\Ticketing\Http\Controllers\SupportQuickSolutionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|e
*/
Route::prefix('ticketing')->middleware(['auth'])->group(function() {

    Route::resources([
        'support-tickets'     => SupportTicketController::class,
        'support-teams'       => SupportTeamController::class,
        'support-complain-types' => SupportComplainTypeController::class,
        'support-solutions' => SupportQuickSolutionController::class,
        'complain-sources' => TicketSourceController::class
    ]);

});
