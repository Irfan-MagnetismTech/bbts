<?php

namespace App\Services;

use App\Mail\ClientEmail;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailService extends Controller
{
//$cc = ['saleha@magnetismtech.com', 'yeasir@bbts.net', 'sikder@bbts.net']
    public function sendEmail($to, $cc, $receiver = null, $subject, $customEmailBody, $button = null) {
        try {
            return Mail::to($to)
            ->cc($cc)
            ->send(new ClientEmail($subject, $customEmailBody, $receiver, $button));
        } catch (\Throwable $th) {
            return true;
        }
    }
}
