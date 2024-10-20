<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Mediji';

$sql = "SELECT * FROM mediji ORDER BY tip";

$db = Database::get();

try {
    $mediaAll = $db->query($sql)->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');

require basePath('views/media/index.view.php');