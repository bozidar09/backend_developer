<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Cjenik';

$sql = "SELECT id, tip_filma AS tip, cijena, zakasnina_po_danu AS zakasnina FROM cjenik ORDER BY tip";

$db = Database::get();

try {
    $prices = $db->query($sql)->all();
    
} catch (\PDOException $e) {
    abort(500);
}

$message = Session::get('message');

require basePath('views/prices/index.view.php');