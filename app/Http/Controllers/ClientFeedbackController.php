<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Ticketing\Entities\SupportTicket;

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
                    'clients_feedback' => $request->feedback,
                    'clients_feedback_details' => $request->comment,
                    'clients_feedback_url' => null
                ]);
            });

            return redirect('https://bbts.net')->with('success', 'Feedback submitted successfully');
        } catch (\Throwable $th) {
            return redirect('https://bbts.net')->with('error', 'Something went wrong');
        }
    }

    public function feedbackList() {
        
    }
}
