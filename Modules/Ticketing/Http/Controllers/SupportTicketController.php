<?php

namespace Modules\Ticketing\Http\Controllers;

use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\SupportQuickSolution;
use Modules\Ticketing\Entities\SupportTeamMember;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\TicketMovement;
use Modules\Ticketing\Http\Requests\SupportTicketRequest;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $from = $request->date_from;
        $to = $request->date_to;

        $supportTickets = SupportTicket::query();

            if (!empty($from)) {
                $supportTickets->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
            }

            if (!empty($to)) {
                $supportTickets->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
            }

            $supportTickets->orderBy('created_at', 'desc')->get();

        $supportTickets = $supportTickets->get();
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
        $clientInfo = ClientDetail::where('id', $request->fr_composit_key)->first();

        if($clientInfo->client->supportTickets->where('status', '!=', 'Closed')->count() > 0) {
            return back()->withInput()->withErrors([
                'message' => 'This client already has previous tickets.'
            ]);
        } 
        
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
        $supportTicket = DB::transaction(function() use($ticketInfo) {
            $ticket = SupportTicket::create($ticketInfo);
            $ticket->supportTicketLifeCycles()->create([
                'status' => $ticketInfo['status'],
                'user_id' => auth()->user()->id,
                'support_ticket_id' => $ticket->id,
                'remarks' => 'Ticket Created.'
            ]);
            return $ticket;
        });

        // Email and SMS Thing
        
        $cc = explode(";", str_replace(" ", "", $request->cc));
        $subject = "[$supportTicket->ticket_no] ".$request->subject;
        $message = $request->description;
        $model = 'Modules\Ticketing\Entities\SupportTicket';
        $receiver = $supportTicket?->clientDetail?->client?->name;
        

        if($request->mailNotification == 1) {
            $to = $supportTicket?->clientDetail?->client?->email;
            $notificationError = (new EmailService())->sendEmail($to, $cc, $receiver, $subject, $message);
        }
        if($request->smsNotification == 1) {
            $to = $supportTicket?->clientDetail?->client?->mobile;
            $notificationError = (new SmsService())->sendSms($to, $message);
        }

        //

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
        $supportTicket->load(['clientDetail' => function($query) {
            $query->select('id', 'client_id')->with(['client' => function($client) {
                $client->select('id', 'name', 'email');
            }]);
        }]);
        $quickSolutions = SupportQuickSolution::get();
        $priorities = config('businessinfo.ticketPriorities');
        return view('ticketing::support-tickets.show', compact('supportTicket', 'complainTypes', 'ticketSources', 'priorities', 'quickSolutions'));
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

            $supportTicket->supportTicketLifeCycles()->create([
                'status' => $ticketInfo['status'],
                'user_id' => auth()->user()->id,
                'support_ticket_id' => $supportTicket->id,
                'remarks' => 'Ticket Updated.'
            ]);
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

    public function acceptTicket(Request $request) {

        if(!empty($request->ticket_id)) {
            try {
                $ticket = SupportTicket::findOrFail($request->ticket_id);
            } catch (\Throwable $th) {
                return back()->withErrors([
                    'message' => 'Invalid Ticket. Your IP is logged in the system.'
                ]);
            }

            if($ticket->status == 'Pending' || $ticket->status == 'Approved') {
                $ticket->status = 'Accepted';

                try {
                    DB::transaction(function() use($ticket) {
                        $ticket->save();

                        $ticket->supportTicketLifeCycles()->create([
                            'status' => 'Accepted',
                            'user_id' => auth()->user()->id,
                            'support_ticket_id' => $ticket->id,
                            'remarks' => 'Ticket Accepted.'
                        ]);
                    });
                
                    return back()->with('message', 'Ticket Accepted Successfully');

                } catch (QueryException $e) {
                    return back()->withErrors([
                        'message' => 'Something went wrong. Check if your internet connection is stable or not.'
                    ]);
                }
                
            } else {
                return back()->withErrors([
                    'message' => 'You cannot accept this ticket. As it is currently '.$ticket->status.'.'
                ]);
            }
        } else {
            return back()->withErrors([
                'message' => 'Invalid Request. Your IP is logged in the system.'
            ]);
        }
    }

    public function addSolution(Request $request) {

        if(!empty($request->ticket_id)) {
            
                $ticket = SupportTicket::findOrFail($request->ticket_id);

                if($ticket->status == 'Pending' || $ticket->status == 'Closed') {
                    return back()->withErrors([
                        'message' => 'You cannot add solution to this ticket.'
                    ]);
                }

                $permissibleUsers = $ticket->supportTicketLifeCycles
                              ->where('status', '!=', 'Pending')
                              ->where('status', '!=', 'Closed')
                              ->where('status', '!=', 'Approved')
                              ->pluck('user_id')
                              ->toArray();

                if(!in_array(auth()->user()->id, $permissibleUsers)) {
                    return back()->withErrors([
                        'message' => 'You cannot add solution to this ticket.'
                    ]);
                } else {
                    try {
                        DB::transaction(function() use($request, $ticket) {
                            $ticket->supportTicketLifeCycles()->create([
                                'status' => collect($ticket->supportTicketLifeCycles)->last()->status,
                                'user_id' => auth()->user()->id,
                                'support_ticket_id' => $ticket->id,
                                'remarks'   => 'Solution Added.',
                                'description' => ($request->quick_solution != 'other') ? $request->quick_solution : $request->custom_solution
                            ]);
                        });

                        return back()->with('message', 'Solution Added Successfully');
                    } catch (QueryException $e) {
                        dd($e);   
                    }
                }

                // Incase of Handover or Forward USER_ID will be blank and it will be available after someone approve it.

        } else {
            return back()->withErrors([
                'message' => 'Invalid Request. Your IP is logged in the system.'
            ]);
        }
    }

    public function forwardedTickets() {
        $userSupportTeam = SupportTeamMember::where('user_id', auth()->user()->id)->get();
        /* 
            The line is eloquent get() method but not first(), 
            because each member might belong to multiple team as Mr. Humayun said.
        */
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover

        $teamIds = $userSupportTeam->map(function($teamMember) {
            return $teamMember->support_team_id;
        })->toArray();
    
        $supportTicketMovements = TicketMovement::where(function($query) use($teamIds) {
            $query->where('movement_model', '\Modules\Ticketing\Entities\SupportTeam')
                  ->whereIn('movement_to', $teamIds)
                  ->orWhere(function($subquery) {
                            $subquery->where('movement_model', '\Modules\Admin\Entities\User')
                                     ->where('movement_to', auth()->user()->id);
                });
        })
        ->where('type', $movementTypes[0])
        ->get();

        $type = 'Forwarded';
        return view('ticketing::support-tickets.forwarded-backward', compact('supportTicketMovements', 'type', 'movementTypes'));
    }

    public function backwardedTickets() {
        
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover
    
        $supportTicketMovements = TicketMovement::where(function($query){
            $query->where('movement_model', '\Modules\Admin\Entities\User')
                  ->where('movement_to', auth()->user()->id);
        })
        ->where('type', $movementTypes[1])
        ->get();

        $type = 'Backwarded';
        return view('ticketing::support-tickets.forwarded-backward', compact('supportTicketMovements', 'type', 'movementTypes'));
    }

    public function handoveredTickets() {
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover
    
        $supportTicketMovements = TicketMovement::where(function($query){
            $query->where('movement_model', '\Modules\Admin\Entities\User')
                  ->where('movement_to', auth()->user()->id);
        })
        ->where('type', $movementTypes[2])
        ->get();

        $type = 'Handovered';
        return view('ticketing::support-tickets.forwarded-backward', compact('supportTicketMovements', 'type', 'movementTypes'));
    }
}
