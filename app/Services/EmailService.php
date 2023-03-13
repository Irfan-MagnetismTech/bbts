<?php

namespace App\Services;

use App\Mail\ClientEmail;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailService extends Controller
{
    public function sendEmail($to, $cc = null, $receiver = null, $subject, $message) {

        try {
            return Mail::to($to)
            ->cc($cc)
            ->send(new ClientEmail($subject, $message, $receiver));
        } catch (\Throwable $th) {
            return true;
        }
        

    }
}
