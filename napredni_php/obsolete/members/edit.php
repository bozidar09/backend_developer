<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi člana';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$sql = "SELECT * FROM clanovi WHERE id = :id";

$db = Database::get();

try {
    $member = $db->query($sql, [
        'id' => $_GET['id'],
    ])->findOrFail();
    
} catch (\PDOException $e) {
    abort(500);
}

$errors = Session::get('errors');

require basePath('views/members/edit.view.php');