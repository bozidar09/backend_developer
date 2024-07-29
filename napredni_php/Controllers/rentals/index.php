<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Posudbe';

$db = Database::get();

$sql = "SELECT 
        ps.id, 
        ps.datum_posudbe AS datum, 
        CONCAT(cl.ime, ' ', cl.prezime) AS clan, 
        f.naslov, 
        f.godina, 
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
    WHERE ps.datum_povrata IS NULL
    ORDER BY datum";

$rentals = $db->query($sql)->all();

$message = Session::all('message');
Session::unflash();

require basePath('views/rentals/index.view.php');