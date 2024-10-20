<?php

use Core\Database;

$pageTitle = 'Prikaz medija';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort();
}

const QUERY = [
    'media' 
        => "SELECT * FROM mediji WHERE id = :id",
    'moviesByMedia' 
        => "SELECT f.*, 
        z.ime AS zanr, 
        c.tip_filma AS tip, 
        COUNT(f.id) AS kolicina
        FROM filmovi f
            JOIN cjenik c ON f.cjenik_id = c.id
            JOIN zanrovi z ON f.zanr_id = z.id
            JOIN kopija k ON k.film_id = f.id 
            JOIN mediji m ON k.medij_id = m.id
        WHERE m.id = :id
        GROUP BY f.id
        ORDER BY f.naslov",
];

$db = Database::get();

try {
    $media = $db->query(QUERY['media'], [
        'id' => $_GET['id'],
    ])->findOrFail();
    
} catch (\PDOException $e) {
    abort(500);
}

$movies = $db->query(QUERY['moviesByMedia'], [
    'id' => $_GET['id'],
])->all();

require basePath('views/media/show.view.php');