<?php

use GuzzleHttp\Client;
use Roamtech\Gateway\Engine\Core;
use Roamtech\Gateway\Native\NativeCache;
use Roamtech\Gateway\Native\NativeConfig;

require "vendor/autoload.php";

$config = new NativeConfig(__DIR__.'/config/roamtechapi.php');
// Configure the HTTP client
$client = new Client(['base_uri' => $config->get('roamtechapi.api_endpoint')]);
//var_dump($config);
$core = new Core($client, $config, new NativeCache($config));
$recipients = ['2547xxxxxxxx'];
$message = 'A test message to say hello and delivery reports';
$options = ['from' => 'Emalify', 'messageId' => '345623', 'callback' => 'http://requestbin.fullcontact.com/q9keweq9'];
$gateway = new \Roamtech\Gateway\Client($core);

// Let us send our message
$response = $gateway->sms()->sendMessage($message, $recipients, $options);

var_dump($response);





$recipients = [
    [
        'phoneNumber' => '254720000000',
        'amount' => 10
    ],
    [
        'phoneNumber' => '254750000000',
        'amount' => 10
    ]
];
$callback = 'https://postb.in/Diw0FQXB';

// initiate the airtime purchase transaction
$response = $gateway->airtime()
    ->setRecipients($recipients)
    ->setCallback($callback)
    ->purchase();

var_dump($response);
