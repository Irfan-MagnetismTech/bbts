<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SmsService extends Controller
{
    public function sendSms($to, $message) {

        try {
            return Http::asForm()
                    ->post('https://rest.nexmo.com/sms/json', [
                        'from' => 'BBTS',
                        'text' => $message,
                        'to' => $to,
                        'api_key' => 'da567500',
                        'api_secret' => 'c8IYs3b2yP4XOeTR'
                ]);

        } catch (\Throwable $th) {
            return true;
        }

    }
}
