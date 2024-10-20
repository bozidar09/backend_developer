<?php

use Core\Database;

$pageTitle = 'Posudba';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['movie']) || !is_numeric($_GET['movie'])) {
    abort(); 
}

$sql = "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
        CASE 
            WHEN ps.datum_povrata IS NULL THEN DATEDIFF(CURDATE(), ps.datum_posudbe)
            ELSE DATEDIFF(ps.datum_povrata, ps.datum_posudbe)
        END AS dani_posudbe,
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

if ($rental['dani_posudbe'] <= 1) {
    $rental['dani_kasnjenja'] = 0;
    $rental['zakasnina_ukupno'] = 0;
    $rental['dugovanje'] = $rental['cijena'];
} else {
    $rental['dani_kasnjenja'] = $rental['dani_posudbe'] - 1;
    $rental['zakasnina_ukupno'] = $rental['dani_kasnjenja'] * $rental['zakasnina'];
    $rental['dugovanje'] = $rental['cijena'] + $rental['zakasnina_ukupno'];
}

require basePath('views/rentals/show.view.php');