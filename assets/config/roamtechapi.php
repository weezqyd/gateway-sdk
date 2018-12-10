<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    |
    | This determines the state of the package, whether to use the sandbox or not.
    |
    | Possible values: sandbox | production
    */

    'status' => env('ROAMTECH_API_ENV', 'sandbox'),

    'production_endpoint' => 'https://roamtech-gateway.appspot.com',

    'client_id' => env('ROAMTECH_API_CLIENT_ID'),

    'client_secret' => env('ROAMTECH_API_CLIENT_SECRET'),
    /*
    |--------------------------------------------------------------------------
    | File Cache Location
    |--------------------------------------------------------------------------
    |
    | This will be the location on the disk where the caching will be done.
    |
    */

    'cache_location' => 'cache',

];
