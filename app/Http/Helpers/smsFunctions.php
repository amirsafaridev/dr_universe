<?php
//require 'autoload.php';

// you api key that generated from panel
use IPPanel\Client;
use IPPanel\Errors\Error;
use IPPanel\Errors\HttpException;
use IPPanel\Errors\ResponseCodes;


function senAuthCode($mobile,$code){
    $apiKey = env("SMS_API_KEY");
    $client = new Client($apiKey);
    $patternValues = [
        env("SMS_LOGIN_PATTERN_VAR") => $code,
    ];
    $messageId = $client->sendPattern(
        env("SMS_LOGIN_PATTERN_CODE"),    // pattern code
        env('SMS_ORIGINATOR'),      // originator
        $mobile,  // recipient
        $patternValues,  // pattern values
    );

    return $messageId;
}
