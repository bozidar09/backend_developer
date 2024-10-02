<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Dodaj nove kopije';

const QUERY = [
    'filmovi'
        => "SELECT * FROM filmovi",
    'mediji'
        => "SELECT * FROM mediji",
];

$db = Database::get();

try {
    $movies = $db->query(QUERY['filmovi'])->all();
    
    $mediaAll = $db->query(QUERY['mediji'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/copies/create.view.php');