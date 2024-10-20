<?php

use Core\Database;

$pageTitle = 'Prikaz člana';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort();
}

const QUERY = [
    'member' 
        => "SELECT * FROM clanovi WHERE id = :id",
    'rentalsByMember' 
        => "SELECT ps.id, ps.datum_posudbe AS datum, 
            CONCAT(cl.ime, ' ', cl.prezime) AS clan, 
            f.naslov, f.godina, 
            z.ime AS zanr, 
            m.tip AS medij,
            ROUND(cj.cijena * m.koeficijent, 2) AS cijena,
            ROUND(((DATEDIFF(CURDATE(), ps.datum_posudbe)-1) * cj.zakasnina_po_danu * m.koeficijent), 2) AS zakasnina
        FROM posudba_kopija pk 
            JOIN posudba ps ON pk.posudba_id = ps.id
            JOIN clanovi cl ON ps.clan_id = cl.id 
            JOIN kopija k ON pk.kopija_id = k.id 
            JOIN mediji m ON k.medij_id = m.id
            JOIN filmovi f ON k.film_id = f.id
            JOIN cjenik cj ON f.cjenik_id = cj.id
            JOIN zanrovi z ON f.zanr_id = z.id
        WHERE cl.id = :id AND ps.datum_povrata IS NULL
        ORDER BY datum",
];

$db = Database::get();

try {
    $member = $db->query(QUERY['member'], [
        'id' => $_GET['id'],
    ])->findOrFail();
    
    $rentals = $db->query(QUERY['rentalsByMember'], [
        'id' => $_GET['id'],
    ])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

require basePath('views/members/show.view.php');