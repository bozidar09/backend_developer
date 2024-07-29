<?php

use Core\Database;

$pageTitle = 'Prikaz člana';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort();
}

$db = Database::get();

$sql = "SELECT * from clanovi WHERE id = :id";

$member = $db->query($sql, [
    'id' => $_GET['id'],
])->findOrFail();

require basePath('views/members/show.view.php');