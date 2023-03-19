<?php
use Illuminate\Support\Facades\Route;
use Modules\Ticketing\Http\Controllers\NotifyClientController;
use Modules\Ticketing\Http\Controllers\SupportTeamController;
use Modules\Ticketing\Http\Controllers\TicketSourceController;
use Modules\Ticketing\Http\Controllers\SupportTicketController;
use Modules\Ticketing\Http\Controllers\SupportComplainTypeController;
use Modules\Ticketing\Http\Controllers\SupportQuickSolutionController;
use Modules\Ticketing\Http\Controllers\TicketMovementController;

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
        'complain-sources' => TicketSourceController::class,
        'ticket-movements' => TicketMovementController::class,
    ]);

    Route::post('/accept-ticket', [SupportTicketController::class, 'acceptTicket'])->name('accept-ticket');
    Route::post('/add-solution', [SupportTicketController::class, 'addSolution'])->name('add-solution');

    Route::get('ticket-movements/{type}/{id}', [TicketMovementController::class, 'moveTicket'])->name('ticket-movements');
    Route::get('notify-client/{ticketId}/{type}', [NotifyClientController::class, 'notifyClient'])->name('notify-client');
    Route::post('send-notification', [NotifyClientController::class, 'sendNotification'])->name('send-notification');

});
