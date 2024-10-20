<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Nova posudba';

const QUERY = [
    'clanovi'
        => "SELECT id AS clan_id, ime, prezime, clanski_broj FROM clanovi",
    'kopije'
        => "SELECT f.id AS film_id, f.naslov, f.godina,
            m.id AS medij_id, m.tip AS medij, 
            COUNT(f.id) AS kolicina
        FROM kopija k
            JOIN mediji m ON m.id = k.medij_id
            JOIN filmovi f ON f.id = k.film_id
        WHERE k.dostupan = 1
        GROUP BY f.id, m.id
        ORDER BY f.naslov",
];

$db = Database::get();

try {
    $members = $db->query(QUERY['clanovi'])->all();

    $copies = $db->query(QUERY['kopije'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/rentals/create.view.php');