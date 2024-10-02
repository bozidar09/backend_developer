<?php

use Core\Session;

$pageTitle = 'Novi žanr';

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/genres/create.view.php');