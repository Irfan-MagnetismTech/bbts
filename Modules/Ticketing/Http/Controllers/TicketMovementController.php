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
            return back()->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
        }

        $supportTeams = (new BbtsGlobalService())->supportTeambyBranch(auth()->user()->employee->branch_id);
        return view('ticketing::ticket-movements.create-edit', compact('movementType', 'ticketId', 'supportTicket', 'supportTeams'));
    }

    public function processTicketMovement(Request $request, $movementType, $ticketId) {
        $movementTypes = config('businessinfo.ticketMovements');
        $pastForms = collect(config('businessinfo.pastForms'));

        try {
            if(!in_array($movementType, $movementTypes)) {
                abort(404);
            }
            
            $supportTicket = SupportTicket::findOrFail($ticketId);
    
            $isEligible = (new BbtsGlobalService())->isEligibleForTicketMovement($ticketId, $movementType);
    
            if(!$isEligible) {
                return back()->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
            }
    
            // Branch or Companywise 
            $supportTeams = (new BbtsGlobalService())->supportTeambyBranch(auth()->user()->employee->branch_id);
    
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
                    $supportTicket->supportTicketLifeCycles()->create([
                        'status' => collect($supportTicket->supportTicketLifeCycles)->last()->status,
                        'user_id' => auth()->user()->id,
                        'support_ticket_id' => $supportTicket->id,
                        'remarks' => $remarks
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
                    $subject = 'New Ticket '. ucfirst($movementType);
                    $message = 'Ticket: '.$supportTicket->ticket_no.' '.$pastForms[$movementType].' to '.$supportTeam->first()->department->name.'.';
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
                ]);
            });
        
            return redirect()->back()->with('message', 'Support Ticket Accepted Successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }
}
