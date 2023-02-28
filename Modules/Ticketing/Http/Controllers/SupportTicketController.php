<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Http\Requests\SupportTicketRequest;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $supportTickets = SupportTicket::orderBy('created_at', 'desc')->get();
        return view('ticketing::support-tickets.index', compact('supportTickets'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        $ticketSources = (new BbtsGlobalService())->getTicketSources();
        $priorities = config('businessinfo.ticketPriorities');
        return view('ticketing::support-tickets.create-edit', compact('complainTypes', 'ticketSources', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SupportTicketRequest $request)
    {
        $lastTicketOfThisMonth = SupportTicket::where('created_at', '>=', Carbon::now()->startOfMonth())
                                ->orderBy('created_at', 'desc')
                                ->first();
        if(empty($lastTicketOfThisMonth)) {
            $ticketIno = Carbon::now()->format('ymd').'-000001';
        } else {
            $ticketIno = (int) substr($lastTicketOfThisMonth->ticket_no, 6) + 1; // substring 6 character because ymd takes 6 character space
            $ticketIno = Carbon::now()->format('ymd').'-'.str_pad($ticketIno, 5, '0', STR_PAD_LEFT);
        }

        $ticketInfo = $request->only([
            'fr_composit_key', 'complain_time', 'description', 'priority', 'remarks', 'sources_id', 'complain_types_id', 'status',
            'mailNotification', 'smsNotification'
        ]);

        $clientInfo = ClientDetail::where('id', $request->fr_composit_key)->first();

        if($clientInfo->client->previousTickets->where('status', '!=', 'Closed')->count() > 0) {
            return back()->withInput()->withErrors([
                'message' => 'This client already has previous tickets.'
            ]);
        } 

        $ticketInfo['ticket_no'] = $ticketIno;
        $ticketInfo['created_by'] = auth()->user()->id;
        $ticketInfo['opening_date'] = Carbon::parse(decrypt($request->opening_date) ?? null)->format('Y-m-d H:i:s');
        $ticketInfo['clients_id'] = $clientInfo->client_id;

        // Below will be derived from $clientInfo object.
        $ticketInfo['branches_id'] = 2;
        $ticketInfo['pops_id'] = 2;
        $ticketInfo['divisions_id'] = 2;
        $ticketInfo['districts_id'] = 2;
        $ticketInfo['thanas_id'] = 2;


        $mailingInfo = $request->only([
            'cc', 'subject', 'body', 'mailNotification', 'smsNotification'
        ]);

       try {
        DB::transaction(function() use($ticketInfo) {
            SupportTicket::create($ticketInfo);
        });
       
        return redirect()->route('support-tickets.index')->with('message', 'Ticket Opened Successfully');
       } catch (QueryException $e) {
        return back()->withInput()->withErrors($e->getMessage());
       }
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ticketing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        return view('ticketing::support-tickets.create-edit', compact('complainTypes'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
