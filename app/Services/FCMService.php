<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Class FCMService
 * @package App\Services
 */
class FCMService
{
    public static function send($token, $notification)
    {
        Http::acceptJson()->withToken(config('fcm.token'))->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'to' => $token,
                'data' => $notification 
            ]
        );
    }
}
