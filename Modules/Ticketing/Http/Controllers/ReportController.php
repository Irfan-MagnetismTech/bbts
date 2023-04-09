<?php

namespace Modules\Ticketing\Http\Controllers;

use App\Services\BbtsGlobalService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ticketing\Entities\SupportTicket;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $supportTickets = SupportTicket::get();
        $ticketSources = (new BbtsGlobalService())->getTicketSources();
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        return view('ticketing::reports.index', compact('supportTickets', 'ticketSources', 'complainTypes'));
    }

    public function pdf(Request $request) {
        return view('ticketing::reports.pdf-complain-types');
    }
}
