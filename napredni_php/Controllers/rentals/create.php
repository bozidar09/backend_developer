<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Nova posudba';

$db = Database::get();

const QUERY = [
    'clanovi'
        => "SELECT 
            c.id AS clan_id, 
            c.ime, 
            c.prezime, 
            c.clanski_broj 
        FROM clanovi c",
    'kopije'
        => "SELECT 
            f.id AS film_id, 
            f.naslov, 
            f.godina,
            m.id AS medij_id, 
            m.tip AS medij, 
            COUNT(f.id) AS kolicina
        FROM kopija k
            JOIN mediji m ON m.id = k.medij_id
            JOIN filmovi f ON f.id = k.film_id
        WHERE k.dostupan = 1
        GROUP BY f.id, m.id
        ORDER BY f.naslov",
];

$members = $db->query(QUERY['clanovi'])->all();

$copies = $db->query(QUERY['kopije'])->all();

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/rentals/create.view.php');