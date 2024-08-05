<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Žanrovi';

$sql = "SELECT * FROM zanrovi z ORDER BY z.ime";

$db = Database::get();

try {
    $genres = $db->query($sql)->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');

require basePath('views/genres/index.view.php');