<?php

use App\Http\Controllers\ClientFeedbackController;
use Illuminate\Support\Facades\Route;
use Modules\Ticketing\Http\Controllers\NotifyClientController;
use Modules\Ticketing\Http\Controllers\PopWiseIssueController;
use Modules\Ticketing\Http\Controllers\ReportController;
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

    Route::get('forwarded-tickets', [SupportTicketController::class, 'forwardedTickets'])->name('forwarded-tickets');
    Route::post('accept-forwarded-tickets', [TicketMovementController::class, 'acceptForwardedTickets'])->name('accept-forwarded-tickets');
    
    Route::get('backwarded-tickets', [SupportTicketController::class, 'backwardedTickets'])->name('backwarded-tickets');

    Route::get('handovered-tickets', [SupportTicketController::class, 'handoveredTickets'])->name('handovered-tickets');

    Route::post('/accept-ticket', [SupportTicketController::class, 'acceptTicket'])->name('accept-ticket');
    Route::post('/add-solution', [SupportTicketController::class, 'addSolution'])->name('add-solution');

    Route::get('ticket-movements/{type}/{id}', [TicketMovementController::class, 'moveTicket'])->name('ticket-movements');
    Route::post('process-ticket-movements/{type}/{id}', [TicketMovementController::class, 'processTicketMovement'])->name('process-ticket-movements');
    Route::post('process-backward-ticket-movements/{type}/{id}', [TicketMovementController::class, 'processTicketMovementBackward'])->name('process-backward-ticket-movements');
    Route::post('process-handover-ticket-movements/{type}/{id}', [TicketMovementController::class, 'processTicketMovementHandover'])->name('process-handover-ticket-movements');

    Route::get('notify-client/{ticketId}/{type}', [NotifyClientController::class, 'notifyClient'])->name('notify-client');
    Route::post('send-notification', [NotifyClientController::class, 'sendNotification'])->name('send-notification');

    Route::get('bulk-email', [PopWiseIssueController::class, 'index'])->name('bulk-email');
    Route::post('send-bulk-email', [PopWiseIssueController::class, 'send'])->name('send-bulk-email');

    Route::get('close-ticket/{supportTicketId}', [SupportTicketController::class, 'closeTicket'])->name('close-ticket');
    Route::post('process-close-ticket/{supportTicketId}', [SupportTicketController::class, 'processCloseTicket'])->name('process-close-ticket');
    
    Route::get('reopen-ticket/{supportTicketId}', [SupportTicketController::class, 'reopenTicket'])->name('reopen-ticket');
    Route::post('process-reopen-ticket/{supportTicketId}', [SupportTicketController::class, 'processReopenTicket'])->name('process-reopen-ticket');

    Route::get('feedback-list', [ClientFeedbackController::class, 'feedbackList'])->name('feedback-list');

    // Ticketing Reports
    Route::prefix('reports')->group(function() {
        Route::get('/', [ReportController::class, 'index'])->name('report-index');
        Route::get('pdf', [ReportController::class, 'pdf'])->name('report-pdf');
    });
});
