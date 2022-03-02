<?php

return [
    'enabled' => env('TRACKER_ENABLED', true),

    'rotes' => [
        'prefix' => env('TRACKER_ROUTE_PREFIX', 'api/admin'),
        'ignore' => [
            'uris' => [

            ]
        ]
    ],

    'database' => [
        'connection' => null,
    ],
];
