<?php

$config = [ 
    'database' => [
        'host' => 'localhost',
        'dbname' => '01_videoteka',
        'user' => 'bozidar',
        'password' => 'bozidar',
        'charset' => 'utf8mb4'
    ],
    'options' => [
        'PDO::ATTR_ERRMODE' => 'PDO::ERRMODE_EXCEPTION',
        'PDO::ATTR_DEFAULT_FETCH_MODE' => 'PDO::FETCH_ASSOC'
    ]
];

// nećemo koristiti http_build_query funkciju jer kodira special characterse
// $dsn = 'mysql:' . http_build_query($config, '', ';');

// kod kompliciranijih statementa unutar "" varijable treba staviti unutar {}
$dsn = "mysql:host={$config['database']['host']};dbname={$config['database']['dbname']};user={$config['database']['user']};password={$config['database']['password']};charset={$config['database']['charset']}";

// druga opcija, ostale varijable uključujući options navodimo prilikom kreiranja nove PDO instance
$dsn = "mysql:host={$config['database']['host']};dbname={$config['database']['dbname']};charset={$config['database']['charset']}";

try {
    $pdo = new PDO($dsn, $config['database']['user'], $config['database']['password'], $config['options']);

    // s obzirom kako smo options već naveli prilikom instanciranja objekta, ne trebamo zvati funkciju setAttribute()...
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // ... te ih možemo izostaviti iz poziva funkcije fetcAll()
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}