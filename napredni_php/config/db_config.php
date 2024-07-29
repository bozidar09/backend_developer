<?php

return [ 
    'host' => 'localhost',
    'dbname' => '01_videoteka',
    'user' => 'bozidar',
    'password' => 'bozidar',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
];