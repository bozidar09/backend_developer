<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Članovi';

$sql = "SELECT * FROM clanovi ORDER BY clanski_broj";

$db = Database::get();

try {
    $members = $db->query($sql)->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');

require basePath('views/members/index.view.php');