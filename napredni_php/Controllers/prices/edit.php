<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi tip filma';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$db = Database::get();

$sql = "SELECT * FROM cjenik WHERE id = :id";

$price = $db->query($sql, [
    'id' => $_GET['id'],
])->findOrFail();

$errors = Session::all('errors');
Session::unflash();

require basePath('views/prices/edit.view.php');