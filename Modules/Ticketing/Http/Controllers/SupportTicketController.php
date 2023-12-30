<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Support\Str;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Carbon;
use Modules\Admin\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Notification;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\TicketMovement;
use App\Notifications\TicketMovementNotification;
use Exception;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Ticketing\Entities\SupportTeamMember;
use Modules\Ticketing\Entities\SupportQuickSolution;
use Modules\Ticketing\Http\Requests\SupportTicketRequest;
use Termwind\Components\Dd;

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
        $supportTicketId = $request->ticket_no;
        $ticketNo = '';
        if (!empty($supportTicketId)) {
            $ticketNo = SupportTicket::findOrFail($supportTicketId)->ticket_no;
        }

        $supportTickets = SupportTicket::when(!empty($from), function ($fromQuery) use ($from) {
            $fromQuery->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
        })
            ->when(!empty($to), function ($toQuery) use ($to) {
                $toQuery->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
            })
            ->when(!empty($supportTicketId), function ($ticketNoQuery) use ($supportTicketId) {
                $ticketNoQuery->where('id', $supportTicketId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ticketing::support-tickets.index', compact('supportTickets', 'ticketNo'));
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
        $clientInfo = Client::where('client_no', $request->client_no)->first();

        // if ($clientInfo->supportTickets->where('status', '!=', 'Closed')->count() > 0) {
        //     return back()->withInput()->withErrors([
        //         'message' => 'This client already has previous tickets.'
        //     ]);
        // }

        $lastTicketOfThisMonth = SupportTicket::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($lastTicketOfThisMonth)) {
            $ticketIno = Carbon::now()->format('ymd') . '-000001';
        } else {
            $ticketIno = (int) substr($lastTicketOfThisMonth->ticket_no, 7) + 1; // substring 6 character because ymd takes 6 character space
            $ticketIno = Carbon::now()->format('ymd') . '-' . str_pad($ticketIno, 6, '0', STR_PAD_LEFT);
        }

        $ticketInfo = $request->only([
            'fr_no', 'complain_time', 'description', 'priority', 'remarks', 'ticket_source_id', 'support_complain_type_id', 'status',
            'mailNotification', 'smsNotification'
        ]);

        $ticketInfo['ticket_no'] = $ticketIno;
        $ticketInfo['created_by'] = auth()->user()->id;
        $ticketInfo['opening_date'] = Carbon::parse(decrypt($request->opening_date) ?? null)->format('Y-m-d H:i:s');
        $ticketInfo['client_no'] = $clientInfo->client_no;

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
            $supportTicket = DB::transaction(function () use ($ticketInfo) {

                $ticket = SupportTicket::create($ticketInfo);
                $ticket->supportTicketLifeCycles()->create([
                    'status' => 'Pending', // We are not taking $ticketInfo['status'] real input as it might be selected as closed.
                    'user_id' => auth()->user()->id,
                    'support_ticket_id' => $ticket->id,
                    'remarks' => 'Ticket Created by ' . auth()->user()->name,
                ]);
                return $ticket;
            });


            // Email and SMS Thing

            $cc = ($request->cc) ? explode(";", str_replace(" ", "", $request->cc)) : null;
            $subject = "[$supportTicket->ticket_no] " . $request->subject;
            $message = $request->description;
            $model = 'Modules\Ticketing\Entities\SupportTicket';
            $receiver = $supportTicket?->client?->client_name;


            if ($request->mailNotification == 1) {
                $to = $supportTicket?->client?->email;
                $notificationError = (new EmailService())->sendEmail($to, $cc, $receiver, $subject, $message);
            }
            if ($request->smsNotification == 1) {
                $to = $supportTicket?->client?->mobile;
                $notificationError = (new SmsService())->sendSms($to, $message);
            }


            if ($supportTicket->status == 'Closed') {
                $supportTicket->supportTicketLifeCycles()->create([
                    'status' => 'Accepted',
                    'user_id' => auth()->user()->id,
                    'support_ticket_id' => $supportTicket->id,
                    'remarks' => 'Ticket Accepted by ' . auth()->user()->name
                ]);

                $supportTicket->update([
                    'status' => 'Accepted'
                ]);

                return redirect()->route('close-ticket', ['supportTicketId' => $supportTicket->id])->with('message', 'Ticket Opened Successfully.');
            }

            return redirect()->route('support-tickets.index')->with('message', 'Ticket Opened Successfully.');
        } catch (QueryException $e) {
            // return back()->withInput()->withErrors($e->getMessage());
            return back()->withInput()->withErrors([
                'message' => 'Something went wrong. Please try again.'
            ]);
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
        $supportTicket->load(['client' => function ($query) {
            $query->select('id', 'client_no', 'email', 'client_name', 'contact_person', 'location', 'contact_no');
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
        $fr_list = FeasibilityRequirementDetail::where('client_no', $supportTicket->client_no)->pluck('fr_no', 'connectivity_point')->toArray();
        $priorities = config('businessinfo.ticketPriorities');
        return view('ticketing::support-tickets.create-edit', compact('supportTicket', 'complainTypes', 'ticketSources', 'priorities', 'fr_list'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SupportTicket $supportTicket, Request $request)
    {
        if ($supportTicket->status == 'Closed') {
            return back()->withInput()->withErrors([
                'message' => 'This ticket is already closed.'
            ]);
        }
        $ticketInfo = $request->only([
            'fr_no', 'complain_time', 'description', 'priority', 'remarks', 'ticket_source_id', 'support_complain_type_id',
            'mailNotification', 'smsNotification'
        ]);

        $clientInfo = Client::where('client_no', $request->client_no)->first();

        $ticketInfo['updated_by'] = auth()->user()->id;
        $ticketInfo['client_no'] = $clientInfo->client_no;

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
            DB::transaction(function () use ($supportTicket, $ticketInfo) {
                $supportTicket->update($ticketInfo);

                $supportTicket->supportTicketLifeCycles()->create([
                    'status' => $supportTicket->status,
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

    public function acceptTicket(Request $request)
    {

        if (!empty($request->ticket_id)) {
            try {
                $ticket = SupportTicket::findOrFail($request->ticket_id);
            } catch (\Throwable $th) {
                return back()->withErrors([
                    'message' => 'Invalid Ticket. Your IP is logged in the system.'
                ]);
            }

            if ($ticket->status == 'Pending' || $ticket->status == 'Approved') {
                $ticket->status = 'Accepted';

                try {
                    DB::transaction(function () use ($ticket) {
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
                    'message' => 'You cannot accept this ticket. As it is currently ' . $ticket->status . '.'
                ]);
            }
        } else {
            return back()->withErrors([
                'message' => 'Invalid Request. Your IP is logged in the system.'
            ]);
        }
    }

    public function addSolution(Request $request)
    {

        if (!empty($request->ticket_id)) {

            $ticket = SupportTicket::findOrFail($request->ticket_id);

            if ($ticket->status == 'Pending' || $ticket->status == 'Closed') {
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

            if (!in_array(auth()->user()->id, $permissibleUsers)) {
                return back()->withErrors([
                    'message' => 'You cannot add solution to this ticket.'
                ]);
            } else {
                try {
                    DB::transaction(function () use ($request, $ticket) {
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
                    return back()->withErrors([
                        'message' => 'Something went wrong. Check if your internet connection is stable or not.'
                    ]);
                }
            }

            // Incase of Handover or Forward USER_ID will be blank and it will be available after someone approve it.

        } else {
            return back()->withErrors([
                'message' => 'Invalid Request. Your IP is logged in the system.'
            ]);
        }
    }

    public function forwardedTickets(Request $request)
    {

        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover

        $filteredTickets = (new BbtsGlobalService())->filterTicketsBasedOnMovement($request, $movementTypes[0]);

        $supportTicketMovements = $filteredTickets['supportTicketMovements'];
        $ticketInfo = $filteredTickets['ticket'];

        $type = 'Forwarded';
        return view('ticketing::support-tickets.forwarded-backward', compact('supportTicketMovements', 'type', 'movementTypes', 'ticketInfo'));
    }

    public function backwardedTickets(Request $request)
    {

        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover
        $filteredTickets = (new BbtsGlobalService())->filterTicketsBasedOnMovement($request, $movementTypes[1]);

        $supportTicketMovements = $filteredTickets['supportTicketMovements'];
        $ticketInfo = $filteredTickets['ticket'];

        $type = 'Backwarded';
        return view('ticketing::support-tickets.forwarded-backward', compact('supportTicketMovements', 'type', 'movementTypes', 'ticketInfo'));
    }

    public function handoveredTickets(Request $request)
    {
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover

        $filteredTickets = (new BbtsGlobalService())->filterTicketsBasedOnMovement($request, $movementTypes[2]);

        $supportTicketMovements = $filteredTickets['supportTicketMovements'];
        $ticketInfo = $filteredTickets['ticket'];

        $type = 'Handovered';
        return view('ticketing::support-tickets.forwarded-backward', compact('supportTicketMovements', 'type', 'movementTypes', 'ticketInfo'));
    }

    public function closeTicket($supportTicketId)
    {
        $supportTicket = SupportTicket::findOrFail($supportTicketId);
        if ($supportTicket->status == 'Closed' || $supportTicket->status == 'Pending' || $supportTicket->status == 'Approved') {
            return redirect()->route('support-tickets.index')->withErrors([
                'message' => 'You cannot close this Ticket at this time. Ticket No: ' . $supportTicket->ticket_no
            ]);
        }
        if (!auth()->user()->hasAnyPermission(['support-ticket-close', 'support-ticket-super-close'])) {
            return redirect()->route('support-tickets.index')->withErrors([
                'message' => 'You do not have permission to close this ticket. Ticket No: ' . $supportTicket->ticket_no
            ]);
        }
        return view('ticketing::support-tickets.close-ticket', compact('supportTicket'));
    }

    public function processCloseTicket(Request $request, $supportTicketId)
    {
        $supportTicket = SupportTicket::findOrFail($supportTicketId);


        $closingDate = Carbon::parse($request->closing_date);
        $complainTime = Carbon::parse($supportTicket->complain_time);
        $now = Carbon::now();

        $minutesDiff = $closingDate->diffInMinutes($complainTime);

        if ($closingDate->diffInMinutes($now, false) < 0) {
            return redirect()->back()->withInput()->withErrors([
                'message' => 'You cannot just close the ticket in future time.'
            ]);
        }

        $info = $request->only(['closing_date', 'feedback_to_client', 'feedback_to_bbts']);
        $info['closed_by'] = auth()->user()->id;
        $info['status'] = 'Closed';
        $info['duration'] = $minutesDiff;


        if ($supportTicket->status == 'Closed' || $supportTicket->status == 'Pending' || $supportTicket->status == 'Approved') {
            return back()->withInput()->withErrors([
                'message' => 'You cannot close this Ticket at this time.'
            ]);
        }

        if (!auth()->user()->hasAnyPermission(['support-ticket-close', 'support-ticket-super-close'])) {
            return back()->withInput()->withErrors([
                'message' => 'You cannot close this ticket.'
            ]);
        }

        try {

            if (!auth()->user()->hasPermissionTo('support-ticket-super-close')) {
                $info['is_temporary_close'] = 1;
            }

            $info['clients_feedback_url'] = Str::random(40);

            DB::transaction(function () use ($supportTicket, $info, $request) {
                $supportTicket->update($info);
                $supportTicket->ticketFeedbacks()->create([
                    'feedbackable_type' => 'Modules\Ticketing\Entities\SupportTicket',
                    'feedbackable_id' => $supportTicket->id,
                    'user_id' => auth()->user()->id,
                    'feedback_to_client' => $request->feedback_to_client,
                    'feedback_to_bbts' => $request->feedback_to_bbts
                ]);
                $supportTicket->supportTicketLifeCycles()->create([
                    'status' => 'Closed',
                    'user_id' => auth()->user()->id,
                    'remarks' => 'Ticket Closed by ' . auth()->user()->name,
                    'description' => $info['feedback_to_bbts'],
                ]);
            });

            $subject = "Your Ticket: $supportTicket->ticket_no is closed.";
            $message = "Your Ticket $supportTicket->ticket_no is now resolved.";
            $message .= "<br /> " . $info['feedback_to_client'];
            $message .= "<br /> You can provide feedback by clicking the following button.";
            $button = [
                'url' => url('/provide-feedback') . "/" . $info['clients_feedback_url'],
                'text' => 'Provide Feedback',
            ];

            $receiver = $supportTicket?->client?->name;


            if ($request->mailNotification == 1) {
                $to = $supportTicket?->client?->email;
                $notificationError = (new EmailService())->sendEmail($to, $cc = null, $receiver, $subject, $message, $button);
            }
            if ($request->smsNotification == 1) {
                $to = $supportTicket?->client?->mobile;
                $notificationError = (new SmsService())->sendSms($to, $message);
            }

            return redirect()->route('support-tickets.index')->with('message', 'Ticket is marked as closed successfully.');
        } catch (QueryException $e) {
            return back()->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function reopenTicket($supportTicketId)
    {
        $supportTicket = SupportTicket::findOrFail($supportTicketId);

        $closingDate = $supportTicket->closing_date;
        $currentTime = \Carbon\Carbon::now();
        $minutesDiff = $currentTime->diffInMinutes($closingDate);
        $reopenValidity = config('businessinfo.ticketReopenValidity');

        if ($supportTicket->status != 'Closed' || $supportTicket->status == 'Pending' || $supportTicket->status == 'Approved' || $minutesDiff > $reopenValidity) {
            return redirect()->route('support-tickets.index')->withErrors([
                'message' => 'You cannot reopen this Ticket. Ticket No: ' . $supportTicket->ticket_no
            ]);
        }

        if (!auth()->user()->hasPermissionTo('support-ticket-reopen')) {
            return redirect()->route('support-tickets.index')->withErrors([
                'message' => 'You do not have permission to reopen this ticket. Ticket No: ' . $supportTicket->ticket_no
            ]);
        }


        return view('ticketing::support-tickets.reopen-ticket', compact('supportTicket'));
    }

    public function processReopenTicket(Request $request, $supportTicketId)
    {
        $supportTicket = SupportTicket::findOrFail($supportTicketId);

        $closingDate = $supportTicket->closing_date;
        $currentTime = \Carbon\Carbon::now();
        $minutesDiff = $currentTime->diffInMinutes($closingDate);

        if ($supportTicket->status != 'Closed' || $minutesDiff > (60 * 24)) {
            return back()->withInput()->withErrors([
                'message' => 'You cannot reopen this Ticket at this time.'
            ]);
        }

        if (!auth()->user()->hasAnyPermission(['support-ticket-reopen'])) {
            return back()->withInput()->withErrors([
                'message' => 'You cannot reopen this ticket.'
            ]);
        }

        try {
            DB::transaction(function () use ($supportTicket, $request) {
                $supportTicket->update([
                    'status' => 'Reopen',
                    'reopened_by' => auth()->user()->id,
                    'reopening_date' => Carbon::now(),
                    'reopen_count' => ($supportTicket->reopen_count + 1)
                ]);

                $supportTicket->supportTicketLifeCycles()->create([
                    'status' => 'Reopen',
                    'user_id' => auth()->user()->id,
                    'remarks' => 'Ticket Reopened by ' . auth()->user()->name,
                    'description' => $request->remarks,
                ]);

                $notificationMessage = "Ticket " . $supportTicket->ticket_no . " is reopened by " . auth()->user()->name;
                $authorizedMember = User::findOrFail($supportTicket->supportTicketLifeCycles->where('status', 'Accepted')->first()->user_id);

                Notification::send($authorizedMember, new TicketMovementNotification($supportTicket, 'reopen', $notificationMessage));
            });


            return redirect()->route('support-tickets.index')->with('message', 'Ticket is reopened successfully.');
        } catch (Exception $e) {
            // return back()->withInput()->withErrors([
            //     'message' => $e->getMessage()
            // ]);

            return back()->withInput()->withErrors([
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }
    public function getClientsByLinkId()
    {
        $results = Client::query()
            ->with([
                'feasibility_requirement_details',
                'connectivities' => function ($query) {
                    $query->where('is_modify', 0);
                }
            ])
            ->where(function ($query) {
                $search = request('search');
                $query->where('client_no', 'LIKE', '%' . $search . '%')
                    ->orWhere('client_name', 'LIKE', '%' . $search . '%');
            })
            ->limit(15)
            ->get()
            ->map(function ($item) {
                $frList = $item->connectivities->flatMap(function ($connectivity) use ($item) {
                    $detail = $item->feasibility_requirement_details
                        ->where('fr_no', $connectivity->fr_no)
                        ->first();
                    if ($detail) {
                        return [$detail->connectivity_point => $detail->fr_no];
                    }
                    return [];
                });

                return [
                    'id' => $item->client_no,
                    'text' => $item->client_no . ' - ' . $item->client_name,
                    'client_name' => $item->client_name,
                    'contact_person' => $item->contact_person,
                    'contact_no' => $item->contact_no,
                    'email' => $item->email,
                    'client_type' => $item->client_type,
                    'address' => $item->location,
                    'fr_list' =>$frList,
                ];
            });

        return response()->json($results);
    }
}
