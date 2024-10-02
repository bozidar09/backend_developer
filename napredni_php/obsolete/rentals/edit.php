<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi posudbu';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['movie']) || !is_numeric($_GET['movie'])) {
    abort(); 
}

$sql = "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
        cl.ime, cl.prezime, cl.clanski_broj,
        pk.kopija_id,
        k.film_id,
        f.naslov, f.godina, 
        m.tip AS medij
    FROM posudba_kopija pk 
        JOIN posudba ps ON pk.posudba_id = ps.id
        JOIN clanovi cl ON ps.clan_id = cl.id 
        JOIN kopija k ON pk.kopija_id = k.id 
        JOIN mediji m ON k.medij_id = m.id
        JOIN filmovi f ON k.film_id = f.id
    WHERE ps.id = :id AND k.film_id = :film_id";

$db = Database::get();

try {
    $rental = $db->query($sql, [
        'id' => $_GET['id'],
        'film_id' => $_GET['movie'],
    ])->findOrFail();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');

require basePath('views/rentals/edit.view.php');