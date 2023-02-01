<?php
use Illuminate\Support\Facades\Route;
use Modules\Ticketing\Http\Controllers\SupportTicketController;

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
Route::prefix('ticketing')->middleware(['auth'])->group(function() {

    Route::resources([
        'support-tickets'     => SupportTicketController::class
    ]);

});
