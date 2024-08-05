<?php

use Core\Session;

$pageTitle = 'Novi član';

$errors = Session::get('errors');
$data = Session::get('data');

require basePath('views/members/create.view.php');