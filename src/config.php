<?php

return [
    'enabled' => env('TRACKER_ENABLED', true),

    'routes' => [
        'prefix' => env('TRACKER_ROUTE_PREFIX', '/api/admin'),
        'ignore' => [
            'uris' => env('TRACKER_IGNORED_ROUTE', '/api/admin/tracks/routes'),
            'methods' => env('TRACKER_IGNORED_METHODS', 'GET')
        ]
    ],

    'database' => [
        'connection' => env('TRACKER_CONNECTION', 'sqlite'),
        'path' => env('TRACKER_DATABASE_PATH', __DIR__ . '/../../../database/database.sqlite'),
        'create' => env('TRACKER_CREATE_DATABASE', true),
    ],

    'user' => [
        'model' => \EscolaLms\Core\Models\User::class
    ]
];
