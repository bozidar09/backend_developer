<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Novi film';

$db = Database::get();

const QUERY = [
    'zanrovi'
        => "SELECT * FROM zanrovi",
    'cjenik'
        => "SELECT * FROM cjenik",
];

$genres = $db->query(QUERY['zanrovi'])->all();

$movieTypes = $db->query(QUERY['cjenik'])->all();

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/movies/create.view.php');