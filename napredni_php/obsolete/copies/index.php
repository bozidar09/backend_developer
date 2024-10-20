<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Količine';

$db = Database::get();

$sql = "SELECT f.id, f.naslov, 
        k.barcode, k.medij_id,
        m.tip AS medij, 
        COUNT(f.id) AS kolicina
    FROM kopija k
        JOIN mediji m ON m.id = k.medij_id
        JOIN filmovi f ON f.id = k.film_id
    GROUP BY f.id, k.barcode, m.tip
    ORDER BY f.naslov";

try {
    $amountAll = $db->query($sql)->all();

} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');

require basePath('views/copies/index.view.php');