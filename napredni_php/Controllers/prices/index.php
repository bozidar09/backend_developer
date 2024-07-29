<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Cjenik';

$db = Database::get();

$sql = "SELECT id, tip_filma AS tip, cijena, zakasnina_po_danu AS zakasnina FROM cjenik ORDER BY tip";

$prices = $db->query($sql)->all();

$message = Session::all('message');
Session::unflash();

require basePath('views/prices/index.view.php');