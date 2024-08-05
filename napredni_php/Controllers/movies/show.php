<?php

use Core\Database;

$pageTitle = 'Prikaz filma';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

const QUERY = [
    'movie' 
        => "SELECT f.*, 
        z.ime AS zanr, 
        GROUP_CONCAT(DISTINCT m.tip) AS medij, 
        c.tip_filma AS tip
        FROM filmovi f
            JOIN cjenik c ON f.cjenik_id = c.id
            JOIN zanrovi z ON f.zanr_id = z.id
            LEFT JOIN kopija k ON k.film_id = f.id 
            LEFT JOIN mediji m ON k.medij_id = m.id
        WHERE f.id = :id
        GROUP BY f.id",
    'copiesByMovie' 
        => "SELECT k.id, k.barcode, k.dostupan,
        f.naslov, 
        m.tip AS medij
        FROM kopija k
            JOIN mediji m ON m.id = k.medij_id
            JOIN filmovi f ON f.id = k.film_id
        WHERE f.id = :id
        ORDER BY k.barcode",
];

$db = Database::get();

try {
    $movie = $db->query(QUERY['movie'], [
        'id' => $_GET['id'],
    ])->findOrFail();
    
    
    $copies = $db->query(QUERY['copiesByMovie'], [
        'id' => $_GET['id'],
        ])->all();
        
} catch (\PDOException $e) {
    abort(500);
}

$movie['medij'] = explode(',', $movie['medij']);
    
require basePath('views/movies/show.view.php');