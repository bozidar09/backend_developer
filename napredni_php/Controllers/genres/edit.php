<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi žanr';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$sql = "SELECT * FROM zanrovi WHERE id = :id";

$db = Database::get();

try {
    $genre = $db->query($sql, [
        'id' => $_GET['id'],
    ])->findOrFail();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');

require basePath('views/genres/edit.view.php');