<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Dodaj nove kopije';

$db = Database::get();

const QUERY = [
    'filmovi'
        => "SELECT * FROM filmovi",
    'mediji'
        => "SELECT * FROM mediji",
];

$movies = $db->query(QUERY['filmovi'])->all();

$mediaAll = $db->query(QUERY['mediji'])->all();

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/copies/create.view.php');