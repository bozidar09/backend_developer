<?php

use Core\Database;

$pageTitle = 'Prikaz tipa filma';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$db = Database::get();

$sql = "SELECT * from cjenik WHERE id = :id";

$price = $db->query($sql, [
    'id' => $_GET['id'],
])->findOrFail();

require basePath('views/prices/show.view.php');