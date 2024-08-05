<?php

use Core\Session;

$pageTitle = 'Novi žanr';

$errors = Session::get('errors');
$data = Session::get('data');

require basePath('views/genres/create.view.php');