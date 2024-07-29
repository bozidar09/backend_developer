<?php

use Core\Session;

$pageTitle = 'Novi član';

$errors = Session::all('errors');
$data = Session::all('data');
Session::unflash();

require basePath('views/members/create.view.php');