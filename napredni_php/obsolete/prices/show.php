<?php

use Core\Database;

$pageTitle = 'Prikaz tipa filma';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

const QUERY = [
    'price' 
        => "SELECT * FROM cjenik WHERE id = :id",
    'moviesByPrice' 
        => "SELECT f.*, 
            z.ime AS zanr, 
            GROUP_CONCAT(DISTINCT m.tip) AS medij, 
            c.tip_filma AS tip
        FROM filmovi f
            JOIN cjenik c ON f.cjenik_id = c.id
            JOIN zanrovi z ON f.zanr_id = z.id
            LEFT JOIN kopija k ON k.film_id = f.id 
            LEFT JOIN mediji m ON k.medij_id = m.id
        WHERE c.id = :id
        GROUP BY f.id
        ORDER BY f.naslov",
];

$db = Database::get();

try {
    $price = $db->query(QUERY['price'], [
        'id' => $_GET['id'],
    ])->findOrFail();
    
    $movies = $db->query(QUERY['moviesByPrice'], [
        'id' => $_GET['id'],
    ])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

foreach ($movies as $key => $movie) {
    $movies[$key]['medij'] = explode(',', $movie['medij']);
}

require basePath('views/prices/show.view.php');