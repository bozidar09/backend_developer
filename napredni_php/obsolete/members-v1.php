<?php

// MVC pattern -> Model - View - Controller

$connection = mysqli_connect('localhost', 'bozidar', 'bozidar', '01_videoteka');

if($connection === false){
    die('Connection failed: '. mysqli_connect_error());
}

$sql = 'SELECT * FROM clanovi;';
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die('There are no memebers in our datbase!');
}

$members = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

$title = 'Članovi';

require 'members_view.php';