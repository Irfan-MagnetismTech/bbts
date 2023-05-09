<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\ClientFeedback;

class ClientFeedbackController extends Controller
{
    public function provideFeedback($slug) {
        $supportTicket = SupportTicket::where('clients_feedback_url', $slug)->first();

        if(!$supportTicket) {
            abort(419);
        }

        return view('client-feedback-form', compact('slug', 'supportTicket'));
    }

    public function storeClientFeedback(Request $request, $slug) {
        $supportTicket = SupportTicket::where('clients_feedback_url', $slug)->first();

        if(!$supportTicket) {
            abort(419);
        }

        try {
            DB::transaction(function () use ($request, $supportTicket) {
                $supportTicket->update([
                    // 'clients_feedback' => $request->feedback,
                    // 'clients_feedback_details' => $request->comment,
                    'clients_feedback_url' => null
                ]);

                $supportTicket->clientFeedbacks()->create([
                    'feedback' => $request->comment,
                    'rating' => $request->feedback,
                    'fr_composite_key' => $supportTicket->fr_composite_key,
                    'client_id' => $supportTicket->client_id
                ]);
            });

            return redirect('https://bbts.net')->with('success', 'Feedback submitted successfully');
        } catch (Exception $th) {
            return $th->getMessage();
            return redirect('https://bbts.net')->with('error', 'Something went wrong');
        }
    }

    public function feedbackList(Request $request) {

        $from = $request->date_from;
        $to = $request->date_to;
        $supportTicketId = $request->ticket_no;
        $ticketNo = '';
        if(!empty($supportTicketId)) {
            $ticketNo = SupportTicket::findOrFail($supportTicketId)->ticket_no;
        }
        $limit = 500;

        $feedbacks = ClientFeedback::when(!empty($from), function($fromQuery) use($from) {
                            $fromQuery->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
                        })
                        ->when(!empty($to), function($toQuery) use($to) {
                            $toQuery->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
                        })
                        ->when(!empty($supportTicketId), function($ticketNoQuery) use($supportTicketId) {
                            $ticketNoQuery->where('support_ticket_id', $supportTicketId);
                        })
                        ->orderBy('created_at', 'desc')
                        ->take($limit)
                        ->get()
                        ->groupBy('support_ticket_id');

        return view('ticketing::client-feedbacks', compact('feedbacks', 'ticketNo'));
    }
}
