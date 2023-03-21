<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Modules\Ticketing\Entities\SupportTeam;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\TicketMovement;

class TicketMovementController extends Controller
{
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

        if(!in_array($movementType, $movementTypes)) {
            abort(404);
        }
        
        $supportTicket = SupportTicket::findOrFail($ticketId);

        $isEligible = (new BbtsGlobalService())->isEligibleForTicketMovement($ticketId, $movementType);

        if(!$isEligible) {
            return back()->withErrors('Ticket is Pending or already closed. Or you are not eligible to move this ticket.');
        }

        $supportTeams = (new BbtsGlobalService())->supportTeambyBranch(auth()->user()->employee->branch_id);

        if(!in_array($request->movement_to, $supportTeams->pluck('id')->toArray())) {
            return back()->withErrors('You are not eligible to move this ticket.');
        }

        $teamMembers = $supportTeams->where('id', $request->movement_to)->first();

        if(!empty($request->teamMemberId)) {
            $movementModel = '\Modules\Admin\Entities\User';
            $teamMember = $teamMembers->supportTeamMembers->where('id', $request->teamMemberId)->first();
            $remarks = 'Ticket '.$pastForms[$movementType].' to '.$teamMember->user->name.' of '.$teamMembers->first()->department->name.'.';

        } else {
            $movementModel = 'App\Models\Dataencoding\Department';
            $remarks = 'Ticket '.$pastForms[$movementType].' to '.$supportTeams->where('id', $request->movement_to)->first()->department->name.'.';
        }
        
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
                    'movement_to' => $request->movement_to,
                    'movement_by' => auth()->user()->id,
                    'status' => 'Pending',
                    'remarks' => $request->remarks,
                    'movement_model' => $movementModel,
                    'movement_date' => now(),
                ]);
            });
        
            return redirect()->back()->with('message', $remarks);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }
}
