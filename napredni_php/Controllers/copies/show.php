<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Kopije';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && !isset($_GET['barcode']) && !isset($_GET['medij'])) {
    $_SESSION['notification'] = 'Greška slanja podataka!';
    redirect('amount'); 
}

$barcode = $_GET['barcode'];
$medij = $_GET['medij'];

$db = Database::get();

$sql = "SELECT k.id, f.naslov, k.barcode, m.tip AS medij, k.dostupan
    FROM kopija k
        JOIN mediji m ON m.id = k.medij_id
        JOIN filmovi f ON f.id = k.film_id
    WHERE k.barcode = :barcode && m.tip = :medij
    ORDER BY k.id";

$copies = $db->query($sql, [
    'barcode' => $barcode, 
    'medij' => $medij,
])->all();

if (empty($copies)) {
    abort();
}

$message = Session::all('message');
Session::unflash();

require basePath('views/copies/show.view.php');