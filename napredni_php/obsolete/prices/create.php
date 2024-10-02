<?php

use Core\Session;

$pageTitle = 'Novi tip filma';

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/prices/create.view.php');