<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Posudbe';

$sql = "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
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
    ORDER BY ps.id";

$db = Database::get();

try {
    $rentals = $db->query($sql)->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');

require basePath('views/rentals/index.view.php');