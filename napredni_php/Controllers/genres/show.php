<?php

use Core\Database;

$pageTitle = 'Prikaz žanra';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$db = Database::get();

$sql = "SELECT * from zanrovi WHERE id = :id";

$genre = $db->query($sql, [
    'id' => $_GET['id'],
])->findOrFail();

require basePath('views/genres/show.view.php');