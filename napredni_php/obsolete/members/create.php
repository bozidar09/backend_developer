<?php

use Core\Session;

$pageTitle = 'Novi član';

$errors = Session::get('errors');
$old = Session::get('old');

require basePath('views/members/create.view.php');