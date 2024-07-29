<?php

use Core\Database;

$pageTitle = 'Prikaz žanra';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$db = Database::get();

const QUERY = [
    'genre' 
        => "SELECT * FROM zanrovi WHERE id = :id",
    'moviesByGenre' 
        => "SELECT f.*, z.ime AS zanr, GROUP_CONCAT(DISTINCT m.tip) AS medij, c.tip_filma AS tip
        FROM filmovi f
            JOIN cjenik c ON f.cjenik_id = c.id
            JOIN zanrovi z ON f.zanr_id = z.id
            LEFT JOIN kopija k ON k.film_id = f.id 
            LEFT JOIN mediji m ON k.medij_id = m.id
        WHERE z.id = :id
        GROUP BY f.id
        ORDER BY f.naslov",
];

$genre = $db->query(QUERY['genre'], [
    'id' => $_GET['id'],
])->findOrFail();

$movies = $db->query(QUERY['moviesByGenre'], [
    'id' => $_GET['id'],
])->all();

foreach ($movies as $key => $movie) {
    $movies[$key]['medij'] = explode(',', $movie['medij']);
}

require basePath('views/genres/show.view.php');