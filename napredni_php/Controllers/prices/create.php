<?php

use Core\Session;

$pageTitle = 'Novi tip filma';

$errors = Session::get('errors');
$data = Session::get('data');

require basePath('views/prices/create.view.php');