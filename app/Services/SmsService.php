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

                // https://api-mapper.clicksend.com/http/v2/send.php?method=http&username=temp.delowar@businessemail.com&key=DD386928-C7FC-A08C-4E89-0FC61AB799FA&to=8801824502831&message=Your+Ticket+is+resolved.

        } catch (\Throwable $th) {
            return true;
        }

    }
}
