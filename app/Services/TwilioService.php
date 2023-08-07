<?php

require __DIR__ . '/../vendor/autoload.php'; 
use Twilio\Rest\Client;

class TwilioService
{
    public static function sendMessageFromTwilio($to, $message)
    {
        $accountSid = getenv('TWILIO_ACCOUNT_SID');
        $authToken = getenv('TWILIO_AUTH_TOKEN');
        $twilioNumber = getenv('TWILIO_PHONE_NUMBER');

        $client = new Client($accountSid, $authToken);

        $client->messages->create(
            $to,
            [
                'from' => $twilioNumber,
                'body' => $message
            ]
        );
    }
}