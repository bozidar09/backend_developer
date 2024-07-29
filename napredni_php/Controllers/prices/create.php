<?php

use Core\Session;

$pageTitle = 'Novi tip filma';

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/prices/create.view.php');