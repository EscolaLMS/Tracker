<?php

return [
    'enabled' => env('TRACKER_ENABLED', true),

    'routes' => [
        'prefix' => env('TRACKER_ROUTE_PREFIX', '/api/admin'),
        'ignore' => [
            '/api/admin/tracks/routes'
        ]
    ],

    'database' => [
        'connection' => env('TRACKER_CONNECTION', env('DB_CONNECTION')),
    ],
];
