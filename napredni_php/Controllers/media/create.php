<?php

use Core\Session;

$pageTitle = 'Novi medij';

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/media/create.view.php');
