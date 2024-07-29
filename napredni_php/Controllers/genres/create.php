<?php

use Core\Session;

$pageTitle = 'Novi žanr';

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/genres/create.view.php');