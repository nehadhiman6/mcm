<?php

namespace App\Lib;

use GuzzleHttp\Client;
use Log;

class SmsOld
{
    protected $guzzle;
    protected $url;
    protected $user;
    protected $pass;
    protected $sender_id;

    public function __construct()
    {
        // $this->guzzle = new Client();
        $this->url = env('SMS_URL');
        $this->user = env('SMS_USER');
        $this->pass = env('SMS_PASSWORD');
        $this->sender_id = env('SMS_SID');
    }

    public function send($msg, $mob_no)
    {
        //     $response = $this->guzzle->get($this->url, [
        //         'form_params' => [
        //             'username'=> $this->user,
        //             'password'=> $this->pass,
        //             'sender' => $this->sender_id,
        //             'to' => $mob_no,
        //             'message' => $msg,
        //             'priority'=> 1,
        //             'dnd'=> 1,
        //             'unicode'=> 0,
        //         ],
        //         'stream' => true,
        //         'synchronous' => true,
        //         'verify' => false,
        //         'headers' => [
        // //            'authorization' => config('college.payu.auth_header'),
        //             'cache-control' => 'no-cache'
        //         ]
        //     ]);
        //     dd($response);
        //     return json_decode($response->getBody()->getContents(), true);
        Log::info($mob_no);
        // return 1;
        return $this->SMSSend($mob_no, $msg);
    }

    private function httpRequest($url)
    {
        $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
        preg_match($pattern, $url, $args);
        // dd($args);
        $in = "";
        $fp = fsockopen($args[1], 80, $errno, $errstr, 30);
        if (!$fp) {
            return ("$errstr ($errno)");
        } else {
            $args[3] = "C" . $args[3];
            $out = "GET /$args[3] HTTP/1.1\r\n";
            $out .= "Host: $args[1]:$args[2]\r\n";
            // $out .= "User-agent: PARSHWA WEB SOLUTIONS\r\n";
            $out .= "Accept: */*\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);
            while (!feof($fp)) {
                $in .= fgets($fp, 128);
            }
        }
        fclose($fp);
        return ($in);
    }

    private function SMSSend($phone, $msg, $debug = false)
    {
        if (strlen(trim($msg)) == 0) {
            return 'Msg required!';
        }
        $url = 'username=' . $this->user;
        $url .= '&password=' . $this->pass;
        $url .= '&sender=' . $this->sender_id;
        $url .= '&to=' . urlencode($phone);
        $url .= '&message=' . urlencode($msg);
        $url .= '&priority=1';
        $url .= '&dnd=1';
        $url .= '&unicode=0';


        $urltouse =  $this->url . '?' . $url;
        if ($debug) {
            echo "Request: <br>$urltouse<br><br>";
        }

        //Open the URL to send the message
        // $response = $this->httpRequest($urltouse);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urltouse);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //Open the URL to send the message
        //$response = httpRequest($urltouse);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($debug) {
            echo "Response: <br><pre>" .
                str_replace(array("<", ">"), array("&lt;", "&gt;"), $response) .
                "</pre><br>";
        }

        return $response;
    }
}
