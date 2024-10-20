<?php

use Core\Database;

const QUERY = [
    'popularMovies'
        => "SELECT f.naslov AS naslov_filma, f.godina AS godina_filma,
            z.ime AS zanr,
            c.tip_filma,
            COUNT(f.id) AS broj_posudbi
        FROM filmovi f
            JOIN zanrovi z ON f.zanr_id = z.id
            JOIN kopija k ON k.film_id = f.id
            JOIN posudba_kopija pk ON pk.kopija_id = k.id
            JOIN posudba ps ON pk.posudba_id = ps.id
            JOIN cjenik c ON f.cjenik_id = c.id
        WHERE ps.datum_posudbe > :datum_posudbe
        GROUP BY k.film_id
        ORDER BY broj_posudbi DESC
        LIMIT 3",
    'moviesWithGenres'
        => "SELECT f.naslov AS naslov_filma, f.godina AS godina_filma,
            z.id AS zanr_id, z.ime AS zanr,
            c.tip_filma
        FROM zanrovi z
            JOIN filmovi f ON f.zanr_id = z.id
            JOIN cjenik c ON f.cjenik_id = c.id",
];

$db = Database::get();

try {
    $popularMovies = $db->query(QUERY['popularMovies'], [
        'datum_posudbe' => '2024-01-01',
    ])->all();
    
    $moviesWithGenres = $db->query(QUERY['moviesWithGenres'])->all();
    
} catch (\PDOException $e) {
    abort(500);
}

foreach ($moviesWithGenres as $key => $movie) {
    $genreName = $movie['zanr'];
    if(!isset($moviesByGenre[$genreName])){
        $moviesByGenre[$genreName] = [];
    }
    if (count($moviesByGenre[$genreName]) < 5){
        $moviesByGenre[$genreName][] = $movie;
    }
}

require basePath('views/home/index.view.php');