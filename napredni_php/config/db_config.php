<?php

$config = [ 
    'db_host' => env('DB_HOST', "database"),
    'db_port' => env('DB_PORT', 3306),
    'db_database' => env('DB_DATABASE', "videoteka"),
    'db_charset' => env('DB_CHARSET', "utf8mb4"),
    'db_username' => env('DB_USERNAME', "algebra"),
    'db_password' => env('DB_PASSWORD', "algebra"),
    'db_options' => env('DB_OPTIONS'),
];

if ($config['db_options']) {
    if (str_contains($config['db_options'] , ',')) {
        $elements = explode(',', $config['db_options']);
    } else {
        $elements[] = $config['db_options'];
    }
    
    $config['db_options'] = [];
    foreach ($elements as $element) {
        $element = explode('=>', $element);
        $config['db_options'][$element[0]] = $element[1];
    }
}