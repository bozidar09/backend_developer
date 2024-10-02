<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Filmovi';

$sql = "SELECT f.*, 
        z.ime AS zanr, 
        GROUP_CONCAT(DISTINCT m.tip) AS medij, 
        c.tip_filma AS tip
    FROM filmovi f
        JOIN cjenik c ON f.cjenik_id = c.id
        JOIN zanrovi z ON f.zanr_id = z.id
        LEFT JOIN kopija k ON k.film_id = f.id 
        LEFT JOIN mediji m ON k.medij_id = m.id
    GROUP BY f.id
    ORDER BY f.naslov";

$db = Database::get();

try {
    $movies = $db->query($sql)->all();
    
} catch (\PDOException $e) {
    abort(500);
}

foreach ($movies as $key => $movie) {
    $movies[$key]['medij'] = explode(',', $movie['medij']);
}

$message = Session::get('message');

require basePath('views/movies/index.view.php');