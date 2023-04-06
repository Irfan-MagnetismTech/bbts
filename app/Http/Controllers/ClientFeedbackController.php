<?php

namespace App\Http\Controllers;

use App\Services\BbtsGlobalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\ClientFeedback;
use Modules\Ticketing\Entities\ClientsFeedback;

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

    public function feedbackList() {
        $feedbacks = (new BbtsGlobalService())->getClientFeedbacks(500)->groupBy('support_ticket_id');

        return view('ticketing::client-feedbacks', compact('feedbacks'));
    }
}
