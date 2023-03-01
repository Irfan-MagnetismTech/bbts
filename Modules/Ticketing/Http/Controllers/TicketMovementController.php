<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\SupportTeam;
use Modules\Ticketing\Entities\SupportTicket;

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
        
        $supportTicket = SupportTicket::find($ticketId);
        $supportTeams = SupportTeam::where('branch_id', auth()->user()->employee->branch_id)->get();
        return view('ticketing::ticket-movements.create-edit', compact('movementType', 'ticketId', 'supportTicket', 'supportTeams'));
    }
}
