<?php

use Core\Database;
use Core\Session;

$pageTitle = 'Članovi';

$db = Database::get();

$sql = "SELECT * FROM clanovi ORDER BY clanski_broj";

$members = $db->query($sql)->all();

$message = Session::all('message');
Session::unflash();

require basePath('views/members/index.view.php');