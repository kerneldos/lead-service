<?php

return [
    'client_service' => [
        'base_url' => env('CLIENT_SERVICE_URL', 'http://127.0.0.1:8084'),
        'timeout' => env('CLIENT_SERVICE_TIMEOUT', 10),
    ],

    'application_service' => [
        'base_url' => env('APPLICATION_SERVICE_URL', 'http://http://127.0.0.1:8085'),
        'timeout' => env('APPLICATION_SERVICE_TIMEOUT', 10),
    ],
];
