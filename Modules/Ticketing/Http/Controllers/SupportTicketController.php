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
            'fr_composit_key', 'complain_time', 'description', 'priority', 'remarks', 'ticket_source_id', 'support_complain_type_id', 'status',
            'mailNotification', 'smsNotification'
        ]);

        $clientInfo = ClientDetail::where('id', $request->fr_composit_key)->first();

        if($clientInfo->client->supportTickets->where('status', '!=', 'Closed')->count() > 0) {
            return back()->withInput()->withErrors([
                'message' => 'This client already has previous tickets.'
            ]);
        } 

        $ticketInfo['ticket_no'] = $ticketIno;
        $ticketInfo['created_by'] = auth()->user()->id;
        $ticketInfo['opening_date'] = Carbon::parse(decrypt($request->opening_date) ?? null)->format('Y-m-d H:i:s');
        $ticketInfo['client_id'] = $clientInfo->client_id;

        // Below will be derived from $clientInfo object.
        $ticketInfo['branch_id'] = 2;
        $ticketInfo['pop_id'] = 2;
        $ticketInfo['division_id'] = 2;
        $ticketInfo['district_id'] = 2;
        $ticketInfo['thana_id'] = 2;


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
    public function show(SupportTicket $supportTicket)
    {
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        $ticketSources = (new BbtsGlobalService())->getTicketSources();
        $priorities = config('businessinfo.ticketPriorities');
        return view('ticketing::support-tickets.show', compact('supportTicket', 'complainTypes', 'ticketSources', 'priorities'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(SupportTicket $supportTicket)
    {
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        $ticketSources = (new BbtsGlobalService())->getTicketSources();
        $priorities = config('businessinfo.ticketPriorities');
        return view('ticketing::support-tickets.create-edit', compact('supportTicket', 'complainTypes', 'ticketSources', 'priorities'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SupportTicket $supportTicket, Request $request)
    {
        $ticketInfo = $request->only([
                        'fr_composit_key', 'complain_time', 'description', 'priority', 'remarks', 'ticket_source_id', 'support_complain_type_id', 'status',
                        'mailNotification', 'smsNotification'
                    ]);

        $clientInfo = ClientDetail::where('id', $request->fr_composit_key)->first();

        $ticketInfo['updated_by'] = auth()->user()->id;
        $ticketInfo['client_id'] = $clientInfo->client_id;

        // Below will be derived from $clientInfo object.
        $ticketInfo['branch_id'] = 2;
        $ticketInfo['pop_id'] = 2;
        $ticketInfo['division_id'] = 2;
        $ticketInfo['district_id'] = 2;
        $ticketInfo['thana_id'] = 2;


        $mailingInfo = $request->only([
        'cc', 'subject', 'body', 'mailNotification', 'smsNotification'
        ]);

        try {
        DB::transaction(function() use($supportTicket, $ticketInfo) {
            $supportTicket->update($ticketInfo);
        });

        return back()->with('message', 'Ticket Updated Successfully');
        } catch (QueryException $e) {
        return back()->withInput()->withErrors($e->getMessage());
        }
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
