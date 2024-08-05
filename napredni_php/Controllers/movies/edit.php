<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi film';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

const QUERY = [
    'film'
        => "SELECT f.*, 
            z.ime AS zanr, 
            c.tip_filma AS tip
        FROM filmovi f
            JOIN zanrovi z ON f.zanr_id = z.id
            JOIN cjenik c ON f.cjenik_id = c.id
        WHERE f.id = :id",
    'zanrovi'
        => "SELECT * FROM zanrovi",
    'cjenik'
        => "SELECT * FROM cjenik",
];

$db = Database::get();

try {
    $movie = $db->query(QUERY['film'], [
        'id' => $_GET['id'],
    ])->findOrFail();
    
    $genres = $db->query(QUERY['zanrovi'])->all();
    
    $movieTypes = $db->query(QUERY['cjenik'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');

require basePath('views/movies/edit.view.php');