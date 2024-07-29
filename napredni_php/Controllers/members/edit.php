<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Uredi člana';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$db = Database::get();

$sql = "SELECT * from clanovi WHERE id = :id";

$member = $db->query($sql, [
    'id' => $_GET['id'],
])->findOrFail();

$errors = Session::all('errors');
Session::unflash();

require basePath('views/members/edit.view.php');