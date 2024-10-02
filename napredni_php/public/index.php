<?php

use Core\Router;

session_start();

require_once '../Core/functions.php';
require_once basePath('Core/bootstrap.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router = Router::getRouter();
$router->route($uri, $method);