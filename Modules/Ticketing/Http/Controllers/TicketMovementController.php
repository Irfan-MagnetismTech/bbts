<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use Modules\Admin\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Services\BbtsGlobalService;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;
use Modules\Ticketing\Entities\SupportTeam;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\TicketMovement;
use Modules\Ticketing\Entities\SupportTeamMember;

class TicketMovementController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ticketing::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ticketing::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
        return view('ticketing::edit');
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

    public function moveTicket(Request $request, $movementType, $ticketId) {
        $movementTypes = config('businessinfo.ticketMovements');

        if(!in_array($movementType, $movementTypes)) {
            abort(404);
        }
        
        $supportTicket = SupportTicket::findOrFail($ticketId);

        $isEligible = (new BbtsGlobalService())->isEligibleForTicketMovement($ticketId, $movementType);

        if(!$isEligible) {
            return redirect()->route('support-tickets.show',$ticketId)->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
        }

        $supportTeams = (new BbtsGlobalService())->getSupportTeam();

        $sameTeamUsers = [];

        // Handover is 2 in array
        if($movementType == $movementTypes[2]) {
            $userTeam = SupportTeamMember::with('supportTeam.supportTeamMembers')
                        ->where('user_id', auth()->user()->id)
                        ->get();

            $sameTeamUserIds = $userTeam->flatMap(function($teamMember) {
                                        return $teamMember->supportTeam->supportTeamMembers->reject(function($user) {
                                        return $user->user_id == auth()->user()->id;
                                    });
                                })->pluck('user_id')->unique()->values()->toArray();

            $sameTeamUsers = User::whereIn('id', $sameTeamUserIds)->get();
        }

        return view('ticketing::ticket-movements.create-edit', compact('movementType', 'movementTypes', 'ticketId', 'supportTicket', 'supportTeams', 'sameTeamUsers'));
    }

    public function processTicketMovement(Request $request, $movementType, $ticketId) {
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover
        $pastForms = collect(config('businessinfo.pastForms'));

        try {
            if(!in_array($movementType, $movementTypes) || $movementType != $movementTypes[0]) {
                abort(404);
            }
            
            $supportTicket = SupportTicket::findOrFail($ticketId);

            $isEligible = (new BbtsGlobalService())->isEligibleForTicketMovement($ticketId, $movementType);
    
            if(!$isEligible) {
                return back()->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
            }
    
            // Mr. Ajoy of BBTS Confirmed Team should not be limited to branch wise as they might not have network or admin team in every branch.
            $supportTeams = (new BbtsGlobalService())->getSupportTeam();
    
            if(!in_array($request->movement_to, $supportTeams->pluck('id')->toArray())) {
                return back()->withErrors('You are not eligible to move this ticket.');
            }
    
            $supportTeam = $supportTeams->where('id', $request->movement_to)->first();

            // $existingMovement = TicketMovement::where('support_ticket_id', $ticketId)->get();
    
            if(!empty($request->teamMemberId)) {
                $movementModel = '\Modules\Admin\Entities\User';
                $teamMember = $supportTeam->supportTeamMembers->where('user_id', $request->teamMemberId)->first();
    
                if(empty($teamMember)) {
                    return back()->withErrors('You cannot forward ticket to this user. Because Team and Employee mismatch.');
                }
    
                $remarks = 'Ticket '.$pastForms[$movementType].' to '.$teamMember->user->name.' of '.$supportTeam->first()->department->name.'.';
    
            } else {
                $movementModel = '\Modules\Ticketing\Entities\SupportTeam';
                $remarks = 'Ticket '.$pastForms[$movementType].' to '.$supportTeams->where('id', $request->movement_to)->first()->department->name.'.';
            }
    
            $allTeamMembersId = $supportTeam->supportTeamMembers->pluck('user_id')->toArray();
    
            $permissionNames = ['receive-email-when-ticket-forwarded', 'receive-email-when-ticket-backwarded', 'receive-email-when-ticket-handovered'];
    
            $mailReceivers = User::whereIn('id', $allTeamMembersId)->whereHas('roles', function($q) use($permissionNames){
                $q->whereHas('permissions', function($q1) use($permissionNames) {
                  $q1->whereIn('name', $permissionNames);
                });
              })->get();
    
            try {
                DB::transaction(function() use($supportTicket, $remarks, $movementModel, $movementType, $request) {

                    $supportTicket->update([
                        'status' => 'Processing'
                    ]);

                    $supportTicket->supportTicketLifeCycles()->create([
                        'status' => 'Processing',
                        'user_id' => auth()->user()->id,
                        'support_ticket_id' => $supportTicket->id,
                        'remarks' => $remarks,
                        'description' => $request->remarks

                    ]);
            
                    TicketMovement::create([
                        'support_ticket_id' => $supportTicket->id,
                        'type' => $movementType,
                        'movement_to' => (!empty($request->teamMemberId)) ? $request->teamMemberId : $request->movement_to,
                        'movement_by' => auth()->user()->id,
                        'status' => 'Pending',
                        'remarks' => $request->remarks,
                        'movement_model' => $movementModel,
                        'movement_date' => now(),
                    ]);
                });
    
                foreach($mailReceivers as $mailReceiver) {
                    $subject = 'Ticket '.$supportTicket->ticket_no.' '. ucfirst($movementType);
                    $message = 'Ticket: '.$supportTicket->ticket_no.' '.$pastForms[$movementType].' to '.$supportTeam->first()->department->name.'.';
                    $message .= "\n\n".$request->remarks;
                    (new EmailService())->sendEmail($mailReceiver->email, null, $mailReceiver->name, $subject, $message);
                }
    
                return redirect()->back()->with('message', $remarks);
    
            } catch (QueryException $e) {
                return redirect()->back()->withInput()->withErrors("Something went wrong. Please try again.");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors("Something went wrong. Please try again.");
        }

    }

    public function processTicketMovementBackward(Request $request, $movementType, $ticketId) {
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover
        $pastForms = collect(config('businessinfo.pastForms'));

        try {
            if(!in_array($movementType, $movementTypes) || $movementType != $movementTypes[1]) {
                abort(404);
            }
            
            $supportTicket = SupportTicket::findOrFail($ticketId);
    
            $isEligible = (new BbtsGlobalService())->isEligibleForTicketMovement($ticketId, $movementType);
    
            if(!$isEligible) {
                return back()->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
            }

            $movementModel = '\Modules\Admin\Entities\User';

            $authorizedMember = $supportTicket->supportTicketLifeCycles->where('status', 'Accepted')->first();

            $remarks = 'Ticket '.$pastForms[$movementType].' to '.$authorizedMember->user->name.' of '.$authorizedMember->user->employee->department->name.'.';

            $permissionNames = ['receive-email-when-ticket-forwarded', 'receive-email-when-ticket-backwarded', 'receive-email-when-ticket-handovered'];
    
            $mailReceivers = User::whereIn('id', [$authorizedMember->user_id])->whereHas('roles', function($q) use($permissionNames){
                $q->whereHas('permissions', function($q1) use($permissionNames) {
                  $q1->whereIn('name', $permissionNames);
                });
              })->get();
    
            try {
                DB::transaction(function() use($supportTicket, $remarks, $movementModel, $movementType, $request, $authorizedMember) {
                    $supportTicket->supportTicketLifeCycles()->create([
                        'status' => 'Processing',
                        'user_id' => auth()->user()->id,
                        'support_ticket_id' => $supportTicket->id,
                        'remarks' => $remarks,
                        'description' => $request->remarks
                    ]);

                    $supportTicket->update([
                        'status' => 'Processing',
                    ]);
                    
                    TicketMovement::create([
                        'support_ticket_id' => $supportTicket->id,
                        'type' => $movementType,
                        'movement_to' =>$authorizedMember->user_id,
                        'movement_by' => auth()->user()->id,
                        'status' => 'Processing',
                        'remarks' => $request->remarks,
                        'movement_model' => $movementModel,
                        'movement_date' => now(),
                    ]);
                });
    
                foreach($mailReceivers as $mailReceiver) {
                    $subject = 'Ticket '.$supportTicket->ticket_no.' '. ucfirst($movementType);
                    $message = 'Ticket: '.$supportTicket->ticket_no.' '.$pastForms[$movementType].'.';
                    $message .= "\n\n".$request->remarks;
                    (new EmailService())->sendEmail($mailReceiver->email, null, $mailReceiver->name, $subject, $message);
                }
    
                return redirect()->back()->with('message', $remarks);
    
            } catch (QueryException $e) {
                return redirect()->back()->withInput()->withErrors("Something went wrong. Please try again.");
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors("Something went wrong. Please try again.");
        }
    }

    public function acceptForwardedTickets(Request $request) {
        $userSupportTeam = SupportTeamMember::where('user_id', auth()->user()->id)->get();
        // The line is get method, because each member might belong to multiple team as Mr. Humayun said.

        $teamIds = $userSupportTeam->map(function($teamMember) {
            return $teamMember->support_team_id;
        })->toArray();

        $movement = TicketMovement::findOrFail($request->movement_id);
        
        if($movement->movement_model == '\Modules\Ticketing\Entities\SupportTeam') {
            if(!in_array($movement->movement_to, $teamIds)) {
                return redirect()->back()->withErrors('You are not eligible to accept this ticket.');
            }
        } else {
            if(!in_array($movement->movement_to, [auth()->user()->id])) {
                return redirect()->back()->withErrors('You are not eligible to accept this ticket.');
            }
        }

        try {
            DB::transaction(function() use($movement) {
                $movement->supportTicket->supportTicketLifeCycles()->create([
                    'status' => collect($movement->supportTicket->supportTicketLifeCycles)->last()->status,
                    'user_id' => auth()->user()->id,
                    'support_ticket_id' => $movement->support_ticket_id,
                    'remarks' => 'Forwarded Ticket Accepted by '.auth()->user()->name.' of '.auth()->user()->employee->department->name.'.'
                ]);
        
                $movement->update([
                    'status' => 'Accepted',
                    'accepted_by' => auth()->user()->id
                ]);
            });
        
            return redirect()->back()->with('message', 'Support Ticket Accepted Successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    public function processTicketMovementHandover(Request $request, $movementType, $ticketId) {
        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover
        $pastForms = collect(config('businessinfo.pastForms'));

        try {
            if(!in_array($movementType, $movementTypes) || $movementType != $movementTypes[2]) {
                abort(404);
            }
            
            $supportTicket = SupportTicket::findOrFail($ticketId);
    
            $isEligible = (new BbtsGlobalService())->isEligibleForTicketMovement($ticketId, $movementType);
    
            if(!$isEligible) {
                return back()->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
            }

            $movementModel = '\Modules\Admin\Entities\User';

            $authorizedMember = User::findOrFail($request->teamMemberId);

            $remarks = 'Ticket '.$pastForms[$movementType].' to '.$authorizedMember->name.' of '.$authorizedMember->employee->department->name.'.';

            $permissionNames = ['receive-email-when-ticket-forwarded', 'receive-email-when-ticket-backwarded', 'receive-email-when-ticket-handovered'];
    
            $mailReceivers = User::whereIn('id', [$request->teamMemberId])->whereHas('roles', function($q) use($permissionNames){
                $q->whereHas('permissions', function($q1) use($permissionNames) {
                  $q1->whereIn('name', $permissionNames);
                });
              })->get();
    
            try {
                DB::transaction(function() use($supportTicket, $remarks, $movementModel, $movementType, $request, $authorizedMember) {
                    $supportTicket->supportTicketLifeCycles()->create([
                        'status' => 'Processing',
                        'user_id' => auth()->user()->id,
                        'support_ticket_id' => $supportTicket->id,
                        'remarks' => $remarks,
                        'description' => $request->remarks
                    ]);

                    $supportTicket->update([
                        'status' => 'Processing',
                    ]);
            
                    TicketMovement::create([
                        'support_ticket_id' => $supportTicket->id,
                        'type' => $movementType,
                        'movement_to' =>$authorizedMember->id,
                        'movement_by' => auth()->user()->id,
                        'status' => 'Processing',
                        'remarks' => $request->remarks,
                        'movement_model' => $movementModel,
                        'movement_date' => now(),
                    ]);
                });
    
                foreach($mailReceivers as $mailReceiver) {
                    $subject = 'Ticket '.$supportTicket->ticket_no.' '. ucfirst($movementType);
                    $message = 'Ticket: '.$supportTicket->ticket_no.' '.$pastForms[$movementType].'.';
                    $message .= "\n\n".$request->remarks;
                    (new EmailService())->sendEmail($mailReceiver->email, null, $mailReceiver->name, $subject, $message);
                }
    
                return redirect()->back()->with('message', $remarks);
    
            } catch (QueryException $e) {
                return redirect()->back()->withInput()->withErrors("Something went wrong. Please try again.");
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors("Something went wrong. Please try again.");
        }
    }
}
