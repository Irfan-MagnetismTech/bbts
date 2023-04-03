<?php

namespace Modules\Ticketing\Http\Controllers;

use App\Notifications\TicketMovementNotification;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Notification;
use Modules\Ticketing\Entities\SupportTicket;

class NotifyClientController extends Controller
{
    public function notifyClient($ticketId, $notificationType) {
        $supportTicket = SupportTicket::findOrFail($ticketId);

        if(!in_array($notificationType, ['email', 'sms'])) {
            abort(404);
        }


        return view('ticketing::notify-client.email', [
            'notificationType' => $notificationType,
            'supportTicket' => $supportTicket,
        ]);
    }

    public function sendNotification(Request $request) {
        $supportTicket = SupportTicket::findOrFail($request->ticket_id);
        $cc = explode(";", str_replace(" ", "", $request->cc));
        $subject = "[$supportTicket->ticket_no] ".$request->subject;
        $message = $request->description;
        $model = 'Modules\Ticketing\Entities\SupportTicket';
        $receiver = $supportTicket?->clientDetail?->client?->name;
        $type = $request->notification_type;

        if(!in_array($type, ['email', 'sms'])) {
            abort(404);
        }


        $smsStatus = true;
        if($type == 'email') {
            $to = $supportTicket?->clientDetail?->email;
            $notificationError = (new EmailService())->sendEmail($to, $cc, $receiver, $subject, $message);
        } else if($type == 'sms') {
            $to = $supportTicket?->clientDetail?->mobile;
            $notificationError = (new SmsService())->sendSms($to, $message);
            $smsStatus = $notificationError->ok();
        }

        if ($notificationError == false || $smsStatus == true) {
            return back()->with('message', ucfirst($type)." has been sent successfully.");
        } else {
            return back()->with('error', 'Something went wrong. Please try again.');
        }

    }

    public function notificationTest($supportTicketId) {
        $supportTicket = SupportTicket::findOrFail($supportTicketId);
        $users = auth()->user();
        $message = "Ticket ".$supportTicket->ticket_no.' ossu';
        Notification::send($users, new TicketMovementNotification($supportTicket, 'backward', auth()->user()->id, $message));

    }
}
