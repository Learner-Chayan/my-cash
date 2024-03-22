<?php

namespace App\Http\SmsGateways;
use App\Models\SmsGateway;
use Exception;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client as TwilioClient;

class Twillio
{

    public $from;
    protected $smsGateway;
    protected $calling_code = "+880";
    public function __construct()
    {
            $this->from             = config("twillio.from");
            $this->smsGateway       = new TwilioClient(
                config("twillio.twilio_account_sid"),
                config("twillio.twilio_auth_token")
            );
    }

    public function send($phone, $message)
    {
        try {
            $this->smsGateway->messages->create($this->calling_code . $phone, [
                'from' => $this->from,
                'body' => $message
            ]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
        }
    }
}