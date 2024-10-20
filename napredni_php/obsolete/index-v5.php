<?php

session_start();

require_once '../other/functions.php';
require_once basePath('other/DbConnect.php');

$dbh = new DbConnect();

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// Verzija 1 -> switch-case
// switch ($uri) {
//     case '/':
//         require getControllers('home/index.php');
//         break;
//     case '/members':
//         require getControllers('members/index.php');
//         break;
//     case '/members/create':
//         require getControllers('members/create.php');
//         break;
//     case '/members/store':
//         require getControllers('members/store.php');
//         break;
//     case '/genres':
//         require getControllers('genres/index.php');
//         break;
//     case '/genres/create':
//         require getControllers('genres/create.php');
//         break;
//     case '/genres/store':
//         require getControllers('genres/store.php');
//         break;
//     case '/genres/show':
//         require getControllers('genres/show.php');
//         break;
//     case '/movies':
//         require getControllers('movies/index.php');
//         break;
//     case '/movies/create':
//         require getControllers('movies/create.php');
//         break;
//     case '/movies/store':
//         require getControllers('movies/store.php');
//             break;
//     case '/prices':
//         require getControllers('prices/index.php');
//         break;
//     case '/prices/create':
//         require getControllers('prices/create.php');
//         break;
//     case '/prices/store':
//         require getControllers('prices/store.php');
//         break;
//     case '/media':
//         require getControllers('media/index.php');
//         break;
//     case '/media/create':
//         require getControllers('media/create.php');
//         break;
//     case '/media/store':
//         require getControllers('media/store.php');
//         break;
//     case '/rentals':
//         require getControllers('rentals/index.php');
//         break;
//     case '/rentals/create':
//         require getControllers('rentals/create.php');
//         break;
//     case '/rentals/store':
//         require getControllers('rentals/store.php');
//         break;
//     case '/amount':
//         require getControllers('amount/index.php');
//         break;
//     case '/amount/create':
//         require getControllers('amount/create.php');
//         break;
//     case '/amount/store':
//         require getControllers('amount/store.php');
//         break;
//     case '/copies':
//         require getControllers('copies/index.php');
//         break;
//     case '/copies/create':
//         require getControllers('copies/create.php');
//         break;
//     case '/copies/store':
//         require getControllers('copies/store.php');
//         break;
//     default:
//         abort(404);   
// }


// Verzija 2 -> file routes_config.php i funkcija basePath
function getPath(array $routes, string $uri): string
{ 
    if (array_key_exists($uri, $routes)) {
        return $routes[$uri]; 
    } else {
        abort(404);
    }
}

$routes = require basePath('other/routes_config.php');
require getPath($routes, $uri);