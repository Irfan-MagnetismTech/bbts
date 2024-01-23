<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\Meeting;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Http\Requests\MeetingRequest;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:client-meeting-view|client-meeting-create|client-meeting-edit|client-meeting-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:client-meeting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client-meeting-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-meeting-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $meetings = Meeting::with('client')->latest()->get();
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
        $data = $request->only(['visit_date', 'sales_representative', 'meeting_start_time', 'meeting_end_time', 'meeting_place', 'client_no', 'purpose', 'client_type', 'created_by']);
        $data['created_by'] = auth()->user()->id;
        $meeting = Meeting::create($data);

        $client = $meeting->client->client_name;
        $to = 'salesadmin@bbts.net';
        $cc = 'yasir@bbts.net';
        $receiver = '';
        $subject = "New Meeting Created";
        $messageBody = "A new meeting has been scheduled for the client $client ($meeting->client_no). Please find the detailed Client Meeting List.";
        $fromAddress = auth()->user()->email;
        $fromName = auth()->user()->name;

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
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
        $data = $request->only(['visit_date', 'sales_representative', 'meeting_start_time', 'meeting_end_time', 'meeting_place', 'client_no', 'purpose', 'client_type', 'created_by']);
        $data['created_by'] = auth()->user()->id;
        $meeting->update($data);

        $client = $meeting->client->client_name;
        $to = 'salesadmin@bbts.net';
        $cc = 'yasir@bbts.net';
        //        $cc = 'shiful@magnetismtech.com';
        $receiver = '';
        $subject = "Meeting Rescheduled";
        $messageBody = "Meeting has been rescheduled for the client $client ($meeting->client_no). Please find the detailed Client Meeting List.";
        $fromAddress = auth()->user()->email;
        $fromName = auth()->user()->name;

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
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

        $client = $meeting->client->client_name;
        $to = $meeting->createdBy->email;
//        $cc = 'shiful@magnetismtech.com';
        $cc = 'yasir@bbts.net';
        $receiver = '';
        $subject = "Meeting Info Updated";
        $messageBody = "Meeting status updated to $meeting->status for client $client ($meeting->client_no). Please find the detailed Client Meeting List.";
        $fromAddress = 'salesadmin@bbts.net';
        $fromName = auth()->user()->name;

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
        return redirect()->route('meeting.index')->with('success', 'Meeting status updated successfully');
    }
}
