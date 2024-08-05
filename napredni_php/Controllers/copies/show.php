<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Kopije';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['barcode']) || !isset($_GET['media']) || !is_numeric($_GET['media'])) {
    abort(); 
}

$db = Database::get();

$sql = "SELECT k.id, k.barcode, k.dostupan,
        f.naslov,      
        m.tip AS medij
    FROM kopija k
        JOIN mediji m ON m.id = k.medij_id
        JOIN filmovi f ON f.id = k.film_id
    WHERE k.barcode = :barcode && m.id = :medij_id
    ORDER BY k.id";

try {
    $copies = $db->query($sql, [
        'barcode' => $_GET['barcode'], 
        'medij_id' => $_GET['media'],
    ])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

if (empty($copies)) {
    abort();
}

$message = Session::get('message');

require basePath('views/copies/show.view.php');