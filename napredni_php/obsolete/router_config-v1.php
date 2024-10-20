<?php

use Controllers\HomeController;
use Controllers\RegisterController;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\RentalsController;
use Controllers\MembersController;
use Controllers\CopiesController;
use Controllers\MediaController;
use Controllers\MoviesController;
use Controllers\PricesController;
use Controllers\GenresController;

return [
    // home
    ['method' => 'GET', 'uri' => '/', 'path' => HomeController::class, 'action' => 'index'],
    // register
    ['method' => 'GET', 'uri' => '/register', 'path' => RegisterController::class, 'action' => 'create'],
    ['method' => 'POST', 'uri' => '/register', 'path' => RegisterController::class, 'action' => 'store'],
    // login
    ['method' => 'GET', 'uri' => '/login', 'path' => LoginController::class, 'action' => 'create'],
    ['method' => 'POST', 'uri' => '/login', 'path' => LoginController::class, 'action' => 'store'],
    ['method' => 'POST', 'uri' => '/logout', 'path' => LoginController::class, 'action' => 'logout'],
    // dashboard          
    ['method' => 'GET', 'uri' => '/dashboard', 'path' => DashboardController::class, 'action' => 'index'],
    ['method' => 'PATCH', 'uri' => '/dashboard/return', 'path' => DashboardController::class, 'action' => 'returnMovie'],
    // rentals          
    ['method' => 'GET', 'uri' => '/rentals', 'path' => RentalsController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/rentals/show', 'path' => RentalsController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/rentals/edit', 'path' => RentalsController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/rentals/create', 'path' => RentalsController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/rentals', 'path' => RentalsController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/rentals', 'path' => RentalsController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/rentals/destroy', 'path' => RentalsController::class, 'action' => 'destroy'],
    // members         
    ['method' => 'GET', 'uri' => '/members', 'path' => MembersController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/members/show', 'path' => MembersController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/members/edit', 'path' => MembersController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/members/create', 'path' => MembersController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/members', 'path' => MembersController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/members', 'path' => MembersController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/members/destroy', 'path' => MembersController::class, 'action' => 'destroy'],
    // copies          
    ['method' => 'GET', 'uri' => '/copies', 'path' => CopiesController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/copies/show', 'path' => CopiesController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/copies/edit', 'path' => CopiesController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/copies/create', 'path' => CopiesController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/copies', 'path' => CopiesController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/copies', 'path' => CopiesController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/copies/destroy', 'path' => CopiesController::class, 'action' => 'destroy'],
    // media          
    ['method' => 'GET', 'uri' => '/media', 'path' => MediaController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/media/show', 'path' => MediaController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/media/edit', 'path' => MediaController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/media/create', 'path' => MediaController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/media', 'path' => MediaController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/media', 'path' => MediaController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/media/destroy', 'path' => MediaController::class, 'action' => 'destroy'],
    // movies          
    ['method' => 'GET', 'uri' => '/movies', 'path' => MoviesController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/movies/show', 'path' => MoviesController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/movies/edit', 'path' => MoviesController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/movies/create', 'path' => MoviesController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/movies', 'path' => MoviesController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/movies', 'path' => MoviesController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/movies/destroy', 'path' => MoviesController::class, 'action' => 'destroy'],
    // prices           
    ['method' => 'GET', 'uri' => '/prices', 'path' => PricesController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/prices/show', 'path' => PricesController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/prices/edit', 'path' => PricesController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/prices/create', 'path' => PricesController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/prices', 'path' => PricesController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/prices', 'path' => PricesController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/prices/destroy', 'path' => PricesController::class, 'action' => 'destroy'],
    // genres           
    ['method' => 'GET', 'uri' => '/genres', 'path' => GenresController::class, 'action' => 'index'],
    ['method' => 'GET', 'uri' => '/genres/show', 'path' => GenresController::class, 'action' => 'show'],
    ['method' => 'GET', 'uri' => '/genres/edit', 'path' => GenresController::class, 'action' => 'edit'],
    ['method' => 'GET', 'uri' => '/genres/create', 'path' => GenresController::class, 'action' => 'create'],
    ['method' => 'PATCH', 'uri' => '/genres', 'path' => GenresController::class, 'action' => 'update'],
    ['method' => 'POST', 'uri' => '/genres', 'path' => GenresController::class, 'action' => 'store'],
    ['method' => 'DELETE', 'uri' => '/genres/destroy', 'path' => GenresController::class, 'action' => 'destroy'],
];