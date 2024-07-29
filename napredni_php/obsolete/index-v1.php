<?php

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

$connection = mysqli_connect('localhost', 'bozidar', 'bozidar', '01_videoteka');

if($connection === false){
    die('Connection failed: '. mysqli_connect_error());
}

const QUERY = [
    'popularMovies'
        => "SELECT
            f.naslov AS naslov_filma,
            f.godina AS godina_filma,
            z.ime AS zanr,
            c.tip_filma,
            COUNT(f.id) AS broj_posudbi
        FROM
            filmovi f
            JOIN zanrovi z ON f.zanr_id = z.id
            JOIN kopija k ON k.film_id = f.id
            JOIN posudba_kopija pk ON pk.kopija_id = k.id
            JOIN posudba ps ON pk.posudba_id = ps.id
            JOIN cjenik c ON f.cjenik_id = c.id
        WHERE ps.datum_posudbe > '2024-01-01'
        GROUP BY k.film_id
        ORDER BY broj_posudbi DESC
        LIMIT 3",
    'moviesWithGenres'
        => 'SELECT
                f.naslov AS naslov_filma,
                f.godina AS godina_filma,
                z.ime AS zanr,
                c.tip_filma
            FROM
                zanrovi z
                JOIN filmovi f ON f.zanr_id = z.id
                JOIN cjenik c ON f.cjenik_id = c.id',
    'combined'
        => 'SELECT 
            genre_name,
            movie_title,
            movie_year
        FROM (
            SELECT 
                zanrovi.ime AS genre_name,
                filmovi.naslov AS movie_title,
                filmovi.godina AS movie_year,
                ROW_NUMBER() OVER (PARTITION BY zanrovi.ime ORDER BY filmovi.naslov) as rn
            FROM 
                filmovi
            JOIN 
                zanrovi ON filmovi.zanr_id = zanrovi.id
        ) as delivery_table
        WHERE rn <= 5
        ORDER BY genre_name, movie_title'
];

function getData(mysqli $connection, $sql): array
{
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) === 0) {
        return ['error' => 'nema podataka za upit'];// TODO: refactor this
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$popularMovies = getData($connection, QUERY['popularMovies']);
$moviesWithGenres = getData($connection, QUERY['moviesWithGenres']);
$moviesByGenre = [];

foreach ($moviesWithGenres as $key => $movie) {
    $genreName = $movie['zanr'];

    if(!isset($moviesByGenre[$genreName])){
        $moviesByGenre[$genreName] = [];

    }

    if (count($moviesByGenre[$genreName]) < 5){
        $moviesByGenre[$genreName][] = $movie;
    }
}

// dd($moviesByGenre);

mysqli_close($connection);


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Videoteka</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="assets/styles.css">
    </head>
    <body>
        <header class="p-3 text-body-secondary">
            <div class="container">
                <div class="d-flex gap-2 flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
                        <span class="fs-4">Videoteka</span>
                    </a>
                    
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 flex-grow-1">
                        <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
                        <li><a href="/members.php" class="nav-link px-2 text-dark">Admin</a></li>
                    </ul>
                    <div class="text-end">
                        <button type="button" class="btn btn-primary me-2">Login</button>
                        <button type="button" class="btn btn-warning">Sign-up</button>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="container py-4">
                <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid">
                        <h1 class="display-5 fw-bold">Najpopularniji filmovi</h1>

                        <ul class="list-group my-5">
                            <?php foreach ($popularMovies as $movie): ?>
                                <li class="list-group-item bg-body-tertiary">
                                    <?= $movie['naslov_filma'] ?> (<?= $movie['godina_filma'] ?>) - <?= $movie['zanr'] ?>
                                    <span class="badge text-bg-primary float-end"><?= $movie['tip_filma']?></span>
                                </li>
                            <?php endforeach ?>
                        </ul>

                        <button class="btn btn-outline-secondary" type="button">Vidi sve!</button>
                    </div>
                </div>             
                
                <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid">
                        <h1 class="display-5 fw-bold">Žanrovi</h1>

                        <div class="d-grid gap-3 mt-5" style="grid-template-columns: 1fr 1fr 1fr;">
                            <?php $counter = 0 ?>
                            <?php foreach ($moviesByGenre as $key => $moviesInGenre): ?>
                                <?php 
                                    $isEven = $counter % 2 == 0;
                                    $counter++;
                                ?>
                                <div class="h-100 p-5 <?= $isEven ? 'text-bg-dark' : 'bg-body-tertiary border' ?> rounded-3">
                                    <h2><?= $key ?></h2>
                                    <ul class="list-group my-4">
                                        <?php foreach ($moviesInGenre as $movie): ?>
                                            <li class="list-group-item <?= $isEven ? 'text-bg-dark' : 'bg-body-tertiary' ?>">
                                                <?= $movie['naslov_filma'] ?> (<?= $movie['godina_filma'] ?>)
                                                <span class="badge text-bg-primary float-end"><?= $movie['tip_filma']?></span>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                    <button class="btn <?= $isEven ? 'btn-outline-light' : 'btn-outline-secondary' ?>" type="button">Vidi vise!</button>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <footer class="py-3">
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-secondary">Features</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-secondary">Pricing</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-secondary">FAQs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-secondary">About</a></li>
                    </ul>
                    <p class="text-center text-secondary">© 2024 Company, Inc</p>
                </footer>
            </div>
        </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="assets/main.js"></script>
</body>
</html>