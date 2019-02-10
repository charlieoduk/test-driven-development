<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clients\TwilioClient;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    private $twilio_client;

    public function __construct(TwilioClient $twilio_client)
    {
        $this->twilio_client = $twilio_client;
    }

    /**
     * Handles the request
     * 
     * @param Request $request
     * 
     * @return void
     */
   public function failed( Request $request )
   {
       $data    = $request->all();
       $payload = json_decode( $data['payload'], true );

       if ( 'failed' === $payload['state'] ) {
           $message = $this->build_message( $payload );
           $this->send_sms( $message );
       } 
       $this->send_sms( $message );   
   }

   /**
   * Send an SMS about the failure
   *
   * @param string $data - json payload
   *
   * @return void
   */
   public function build_message( $data )
   {
       $committer_name = $data['committer_name'];
       $commited_at    = $data['committed_at'];
       $build_url      = $data['build_url'];

       $message ="Hi there, I hate to be the bearer of bad news but your build has failed :-("
       .". The commit was made by $committer_name at $commited_at. For more information, please check it "
       . "out here: $build_url.";

       return $message;
   }

   /**
   * Send an SMS about the failure
   *
   * @param string $message - failure message
   *
   * @return void
   */
   public function send_sms( $message = '' )
   {
       $send_sms_to = "YOUR VERIFIED NUMBER";

       $my_twilio_number = env( "TWILIO_NUMBER" );

       $this->twilio_client->send_sms( $send_sms_to, $my_twilio_number, $message );

   }
}
