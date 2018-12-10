<?php
/**
 * Created by PhpStorm.
 * User: leitato
 * Date: 12/7/18
 * Time: 3:26 PM
 */

define("LOCAL_ENDPOINT", 'http://api.gateway.local');

define("SANDBOX_ENDPOINT", 'https://api.sandbox.roamtech.com');

define("PRODUCTION_ENDPOINT", 'https://roamtech-gateway.appspot.com');

/**
 * @param string $env
 * @return string
 * @throws \Roamtech\Gateway\Exceptions\ErrorException
 */
function get_api_url($env) {
    switch ($env) {
        case 'local':
            return LOCAL_ENDPOINT;
            break;
        case 'production':
            return PRODUCTION_ENDPOINT;
            break;
        case 'sandbox':
            return SANDBOX_ENDPOINT;
            break;
        default:
            throw new \Roamtech\Gateway\Exceptions\ErrorException(['status' => 'error', 'message' => "No URL found fro the environment {$env}"]);


    }
}