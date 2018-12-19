<?php

return [
    'mysql' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'database'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', false),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => env('DB_PREFIX', ''),
    ]
];