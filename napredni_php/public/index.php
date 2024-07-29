<?php

// CRUD => C = create; R = read; U = update, D = delete;

session_start();

require_once '../Core/functions.php';
require_once basePath('Core/bootstrap.php');

use Core\Router;

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$router = new Router();
$router->getPath($uri);