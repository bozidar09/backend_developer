<?php

use Core\Session;

$pageTitle = 'Novi medij';

$errors = Session::get('errors');
$data = Session::get('data');

require basePath('views/media/create.view.php');
