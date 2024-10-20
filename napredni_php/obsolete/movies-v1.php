<?php

$connection = mysqli_connect('localhost', 'bozidar', 'bozidar', '01_videoteka');

if($connection === false){
    die('Connection failed: '. mysqli_connect_error());
}

$sql = 'SELECT f.*, z.ime AS zanr, c.tip_filma AS tip
        FROM filmovi f 
            JOIN cjenik c ON f.cjenik_id = c.id
            JOIN zanrovi z ON f.zanr_id = z.id;';
            
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die('There are no movies in our datbase!');
}

$movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

$title = 'Filmovi';

require 'movies_view.php';