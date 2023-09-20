<?php

namespace App\Lib;

use GuzzleHttp\Client;
use Log;

class Sms
{
    protected $guzzle;
    protected $url;
    protected $user;
    protected $pass;
    protected $sender_id;

    public function __construct()
    {
    }

    public function send($msg, $mob_no, $template_id = "")
    {
        Log::info($mob_no);
        // return 1;
        if(env('APP_ENV', 'production') == 'local') {
            $mob_no = "9216561087";
        }
        return $this->SMSSend($mob_no, $msg, $template_id);
    }

    private function SMSSend($phone, $msg, $template_id = "", $debug = false)
    {
        $api_key = config('services.easyway.api_key');
        $contacts = $phone;
        $from = config('services.easyway.sender_id');
        $sms_text = urlencode($msg);


        //Submit to server
        logger("http://login.easywaysms.com/app/smsapi/index.php?" . "key=" . $api_key . "&campaign=0&routeid=7&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://login.easywaysms.com/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=0&routeid=7&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id);
        $response = curl_exec($ch);
        curl_close($ch);


        echo $response;
    }
}
