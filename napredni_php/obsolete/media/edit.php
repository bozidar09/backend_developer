<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi medij';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$sql = "SELECT * FROM mediji WHERE id = :id";

$db = Database::get();

try {
    $media = $db->query($sql, [
        'id' => $_GET['id'],
    ])->findOrFail();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');

require basePath('views/media/edit.view.php');