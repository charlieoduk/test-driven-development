<?php

namespace App\Clients;

use Twilio\Rest\Client;

class TwilioClient
{
    protected $client;

    public function __construct()
    {
        $twilio_sid   = getenv( "TWILIO_SID" );
        $twilio_token = getenv( "TWILIO_TOKEN" );

        $this->client = new Client( $twilio_sid, $twilio_token );
    }

   /**
    * Send an SMS 
    *
    * @param string $message
    *
    * @return void
    */
    public function send_sms( $to, $from, $message )
    {
        $message = $this->client->messages->create($to, [

            'from' => $from,
            'body' => $message

        ]);
    }
}
