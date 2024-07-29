<?php

use Core\Database;

$pageTitle = 'Prikaz medija';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort();
}

$db = Database::get();

$sql = "SELECT * from mediji WHERE id = :id";

$media = $db->query($sql, [
    'id' => $_GET['id'],
])->findOrFail();

require basePath('views/media/show.view.php');