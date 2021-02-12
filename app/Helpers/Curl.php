<?php

namespace App\Helpers;

class Curl
{
    public static function run($path, $params)
    {
        $url = env('API_URL')."$path?" . $params;
        $ch = curl_init($url);
        // if ($method == 'post') {
        //     curl_setopt($ch, CURLOPT_POST, 1);
        // }
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
            ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        // return json_decode($response);
    }
}