<?php

namespace Modules\Sales\Http\Controllers;

use Carbon\Carbon;
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
        $meetings = Meeting::with('client')
            ->clone();
        if (!auth()->user()->hasRole(['Admin', 'Super-Admin'])) {
            $meetings = $meetings->where('created_by', auth()->user()->id);
        }
        $meetings = $meetings->latest()->get();
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
        $data['meeting_start_time'] = Carbon::createFromFormat('H:i', $request->input('meeting_start_time'))->format('g:i A');
        $data['meeting_end_time'] = Carbon::createFromFormat('H:i', $request->input('meeting_end_time'))->format('g:i A');
        $meeting = Meeting::create($data);

        $client = $meeting?->client->client_name ?? '';
        $client_number = $meeting->client_no ?? '';
        $visit_date = $meeting->visit_date ?? '';
        $meeting_start_time = $meeting->meeting_start_time ?? '';
        $meeting_end_time = $meeting->meeting_end_time ?? '';
        $meeting_place = $meeting->meeting_place ?? '';
        $purpose = $meeting->purpose ?? '';
        $status = $meeting->status ?? '';
        $fromAddress = auth()->user()->email;
        $fromName = auth()->user()->name;
        $to = 'salesadmin@bbts.net';
        $cc = ['yasir@bbts.net', 'shiful@magnetismtech.com', 'saleha@magnetismtech.com', $fromAddress];
        $receiver = '';
        $subject = "New Meeting Created";
        $messageBody = "Dear Sir,\n
        I am writing to inform you about a new meeting has been scheduled for our esteemed client, $client ($client_number). \n
        Meeting Details:
        Client: $client
        Client No: $client_number
        Visit Date: $visit_date
        Meeting Start Time: $meeting_start_time
        Meeting End Time: $meeting_end_time
        Meeting Place: $meeting_place
        Meeting Purpose: $purpose
        Meeting Status: $status \n
        Please find the details from software in Client Meeting List.
        Thank you for your attention to this matter. I look forward to your guidance and support.\n
        Best regards,
        $fromName";

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
        $data['meeting_start_time'] = Carbon::createFromFormat('H:i', $request->input('meeting_start_time'))->format('g:i A');
        $data['meeting_end_time'] = Carbon::createFromFormat('H:i', $request->input('meeting_end_time'))->format('g:i A');
        $meeting->update($data);

        $client = $meeting?->client->client_name ?? '';
        $client_number = $meeting->client_no ?? '';
        $visit_date = $meeting->visit_date ?? '';
        $meeting_start_time = $meeting->meeting_start_time ?? '';
        $meeting_end_time = $meeting->meeting_end_time ?? '';
        $meeting_place = $meeting->meeting_place ?? '';
        $purpose = $meeting->purpose ?? '';
        $status = $meeting->status ?? '';
        $fromAddress = auth()->user()->email;
        $fromName = auth()->user()->name;
        $to = 'salesadmin@bbts.net';
        $cc = ['yasir@bbts.net', 'shiful@magnetismtech.com', 'saleha@magnetismtech.com', $fromAddress];
        $receiver = '';
        $subject = "Meeting Rescheduled";
        $messageBody = "Dear Sir,\n
        I am writing to inform you about Meeting has been rescheduled for our esteemed client, $client ($client_number). \n
        Meeting Details:
        Client: $client
        Client No: $client_number
        Visit Date: $visit_date
        Meeting Start Time: $meeting_start_time
        Meeting End Time: $meeting_end_time
        Meeting Place: $meeting_place
        Meeting Purpose: $purpose
        Meeting Status: $status \n
        Please find the details from software in Client Meeting List.
        Thank you for your attention to this matter. I look forward to your guidance and support.\n
        Best regards,
        $fromName";
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

        $client = $meeting?->client->client_name ?? '';
        $client_number = $meeting->client_no ?? '';
        $visit_date = $meeting->visit_date ?? '';
        $meeting_start_time = $meeting->meeting_start_time ?? '';
        $meeting_end_time = $meeting->meeting_end_time ?? '';
        $meeting_place = $meeting->meeting_place ?? '';
        $purpose = $meeting->purpose ?? '';
        $status = $meeting->status ?? '';
        $fromAddress = 'salesadmin@bbts.net';
        $fromName = auth()->user()->name;
        $to = $meeting->createdBy->email;
        $toName = $meeting->createdBy->name ?? '';
        $cc = ['yasir@bbts.net', 'shiful@magnetismtech.com', 'saleha@magnetismtech.com', $fromAddress];
        $receiver = '';
        $subject = "Meeting Status Updated";
        $messageBody = "Dear $toName,\n
        I am writing to inform you about Meeting status updated to $status for our esteemed client, $client ($client_number). \n
        Meeting Details:
        Client: $client
        Client No: $client_number
        Visit Date: $visit_date
        Meeting Start Time: $meeting_start_time
        Meeting End Time: $meeting_end_time
        Meeting Place: $meeting_place
        Meeting Purpose: $purpose
        Meeting Status: $status \n
        Please find the details from software in Client Meeting List.
        Thank you for your attention to this matter. I look forward to your guidance and support.\n
        Best regards,
        $fromName";

        Mail::raw($messageBody, function ($message) use ($to, $cc, $subject, $fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)->to($to)->cc($cc)->subject($subject);
        });
        return redirect()->route('meeting.index')->with('success', 'Meeting status updated successfully');
    }
}
