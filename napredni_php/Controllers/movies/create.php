<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Novi film';

const QUERY = [
    'zanrovi'
        => "SELECT * FROM zanrovi",
    'cjenik'
        => "SELECT * FROM cjenik",
];

$db = Database::get();

try {
    $genres = $db->query(QUERY['zanrovi'])->all();

    $movieTypes = $db->query(QUERY['cjenik'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');
$data = Session::get('data');

require basePath('views/movies/create.view.php');