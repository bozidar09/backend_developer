<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Žanrovi';

$db = Database::get();

$sql = "SELECT * FROM zanrovi z ORDER BY z.ime";

$genres = $db->query($sql)->all();

$message = Session::all('message');
Session::unflash();

require basePath('views/genres/index.view.php');