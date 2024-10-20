<?php

$connection = mysqli_connect('localhost', 'bozidar', 'bozidar', '01_videoteka');

if($connection === false){
    die('Connection failed: '. mysqli_connect_error());
}

$sql = 'SELECT * FROM zanrovi;';
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die('There are no genres in our datbase!');
}

$genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

$title = 'Žanrovi';

require 'genres_view.php';