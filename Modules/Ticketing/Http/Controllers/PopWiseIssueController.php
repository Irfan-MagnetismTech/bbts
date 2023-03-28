<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\ClientDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\PopWiseIssue;
use Modules\Ticketing\Http\Requests\PopWiseIssueRequest;

class PopWiseIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ticketing::bulk-email.email');
    }

    public function send(PopWiseIssueRequest $request) {
        $branchId = $request->branch_id;
        $popId = $request->pop_id;
        $subject = $request->subject;
        $message = $request->description;
        $cc = explode(";", str_replace(" ", "", $request->cc));

        $allLinks = ClientDetail::where('branch_id', $branchId)->where('pop_id', $popId)->get();
        $receiverName = 'Valued Customer';

        if(empty($allLinks) || ($request->status == 'Open' && empty($request->issue_started)) || ($request->status == 'Resolved' && empty($request->issue_resolved))) {
            return back()->withInput()->withErrors('Invalid Data.');
        }

        if($request->status == 'Resolved') {
            $popwiseIssues = PopWiseIssue::where([
                'branch_id'=> $branchId,
                'pop_id'=> $popId,
                'status' => 'Open'
                ])->get();


            if(count($popwiseIssues) < 1) {
                $date1 = \Carbon\Carbon::parse($request->issue_started);
                $date2 = \Carbon\Carbon::parse($request->issue_resolved);
                $duration = $date1->diffInMinutes($date2);
                foreach($allLinks as $receiver) {
                    PopWiseIssue::create([
                        'branch_id' => $branchId,
                        'pop_id' => $popId,
                        'client_id' => $receiver->client_id,
                        'client_detail_id' => $receiver->id,
                        'subject' => $subject,
                        'status'    => 'Resolved',
                        'issue_started' => $request->issue_started ?? null,
                        'issue_resolved' => $request->issue_resolved ?? null,
                        'duration' => $duration
                    ]);
                }
            } else {

                $date1 = \Carbon\Carbon::parse($popwiseIssues->first()->issue_started);
                $date2 = \Carbon\Carbon::parse($request->issue_resolved);
                $duration = $date1->diffInMinutes($date2);

                foreach($popwiseIssues as $issue) {
                    $issue->update([
                        'status' => 'Resolved',
                        'issue_resolved' => $request->issue_resolved ?? null,
                        'duration' => $duration
                    ]);
                }
            }
        } else {
            foreach($allLinks as $receiver) {

                    PopWiseIssue::create([
                        'branch_id' => $branchId,
                        'pop_id' => $popId,
                        'client_id' => $receiver->client_id,
                        'client_detail_id' => $receiver->id,
                        'subject' => $subject,
                        'status'    => 'Open',
                        'issue_started' => $request->issue_started ?? null,
                        'issue_resolved' => $request->issue_resolved ?? null,
                    ]);
            }
        }

        foreach($allLinks as $receiver) {
            (new EmailService())->sendEmail($receiver->email, $cc, $receiverName, $subject, $message);
        }

        return back()->with('message', 'Email Sent Successfully.');

    }
}
