<?php

use Core\Session;

$pageTitle = 'Novi medij';

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/media/create.view.php');
