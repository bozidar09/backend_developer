<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Novi film';

const QUERY = [
    'zanrovi'
        => "SELECT * FROM zanrovi",
    'cjenik'
        => "SELECT * FROM cjenik",
    'mediji'
        => "SELECT * FROM mediji",
];

$db = Database::get();

try {
    $genres = $db->query(QUERY['zanrovi'])->all();

    $movieTypes = $db->query(QUERY['cjenik'])->all();

    $mediaAll = $db->query(QUERY['mediji'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/movies/create.view.php');