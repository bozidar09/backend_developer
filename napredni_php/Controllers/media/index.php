<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Mediji';

$db = Database::get();

$sql = "SELECT * FROM mediji ORDER BY tip";

$mediaAll = $db->query($sql)->all();

$message = Session::all('message');
Session::unflash();

require basePath('views/media/index.view.php');