<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\Meeting;
use Modules\Sales\Http\Requests\MeetingRequest;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $meetings = Meeting::with('client')->get();
        return view('sales::meeting.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $clients = LeadGeneration::get();
        return view('sales::meeting.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(MeetingRequest $request)
    {
        $data = $request->only(['visit_date', 'sales_representative', 'meeting_start_time', 'meeting_end_time', 'meeting_place', 'client_no', 'purpose']);
        Meeting::create($data);
        return redirect()->route('meeting.index')->with('success', 'Meeting created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Meeting $meeting)
    {
        $previous_meetings = Meeting::where('client_no', $meeting->client_id)->where('id', '!=', $meeting->id)->get();
        return view('sales::meeting.show', compact('meeting', 'previous_meetings'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Meeting $meeting)
    {
        $clients = LeadGeneration::get();
        return view('sales::meeting.create', compact('meeting', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $data = $request->only(['visit_date', 'sales_representative', 'meeting_start_time', 'meeting_end_time', 'meeting_place', 'client_no', 'purpose']);
        $meeting->update($data);
        return redirect()->route('meeting.index')->with('success', 'Meeting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meeting.index')->with('success', 'Meeting deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->update(['status' => $request->status]);
        return redirect()->route('meeting.index')->with('success', 'Meeting status updated successfully');
    }
}
