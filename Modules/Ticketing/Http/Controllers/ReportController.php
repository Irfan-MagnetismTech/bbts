<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Admin\Entities\Pop;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Client;
use App\Services\BbtsGlobalService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\SupportTicket;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $from = $request->date_from;
        $to = $request->date_to;
        $status = $request->status;

        $source = $request->ticket_source_id;
        $problemType = $request->support_complain_type_id;
        $priority = $request->priority;

        $popId = $request->pop_id;
        $clientId = $request->client_id;
        $duration = null;

        if(!empty($request->duration)) {
            $duration = (new BbtsGlobalService())->convertToMinutes($request->duration);
        }

        $supportTickets = SupportTicket::when(!empty($from), function($fromQuery) use($from) {
            $fromQuery->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
        })
        ->when(!empty($to), function($toQuery) use($to) {
            $toQuery->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
        })
        ->when(!empty($status), function($statusQuery) use($status) {
            $statusQuery->where('status', $status);
        })
        ->when(!empty($source), function($sourceQuery) use($source) {
            $sourceQuery->where('ticket_source_id', $source);
        })
        ->when(!empty($problemType), function($problemTypeQuery) use($problemType) {
            $problemTypeQuery->where('support_complain_type_id', $problemType);
        })
        ->when(!empty($priority), function($priorityQuery) use($priority) {
            $priorityQuery->where('priority', $priority);
        })
        ->when(!empty($popId), function($popIdQuery) use($popId) {
            $popIdQuery->where('pop_id', $popId);
        })
        ->when(!empty($clientId), function($clientIdQuery) use($clientId) {
            $clientIdQuery->where('client_id', $clientId);
        })
        ->when(!empty($duration), function($durationQuery) use($duration) {
            $durationQuery->where('duration', '<=', $duration);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $ticketSources = (new BbtsGlobalService())->getTicketSources();
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        $popInfo = Pop::where('id', $popId)->first();
        $clientInfo = Client::select('id', 'name')->where('id', $clientId)->first();

        return view('ticketing::reports.index', compact('supportTickets', 'ticketSources', 'complainTypes', 'request', 'popInfo', 'clientInfo'));
    }

    public function pdf(Request $request) {
        return view('ticketing::reports.pdf-complain-types');
    }
}
