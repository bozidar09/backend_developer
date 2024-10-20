<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Nova posudba';

$db = Database::get();

const QUERY = [
    'clanovi'
        => "SELECT c.id AS clan_id, c.ime, c.prezime, c.clanski_broj 
        FROM clanovi c",
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
    'posudbe'
        => "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
            cl.ime, cl.prezime, cl.clanski_broj,
            k.film_id,
            pk.kopija_id,
            f.naslov, f.godina, 
            z.ime AS zanr, 
            m.tip AS medij,
            ROUND(cj.cijena * m.koeficijent, 2) AS cijena,
            ROUND(cj.zakasnina_po_danu * m.koeficijent, 2) AS zakasnina
        FROM posudba_kopija pk 
            JOIN posudba ps ON pk.posudba_id = ps.id
            JOIN clanovi cl ON ps.clan_id = cl.id 
            JOIN kopija k ON pk.kopija_id = k.id 
            JOIN mediji m ON k.medij_id = m.id
            JOIN filmovi f ON k.film_id = f.id
            JOIN cjenik cj ON f.cjenik_id = cj.id
            JOIN zanrovi z ON f.zanr_id = z.id
        WHERE datum_povrata IS NULL
        ORDER BY ps.id",
];

try {
    $members = $db->query(QUERY['clanovi'])->all();

    $copies = $db->query(QUERY['kopije'])->all();

    $rentals = $db->query(QUERY['posudbe'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');
$errors = Session::get('errors');

require basePath('views/dashboard/index.view.php');