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
use Core\Router;

// /** @var Router $router */ -> način da vscode prikazuje opis metode u fileu gdje nema instance klase
// $router->get('/', ['path' => HomeController::class, 'action' => 'index']);

// home
$this->get('/', ['path' => HomeController::class, 'action' => 'index']);
// register
$this->get('/register', ['path' => RegisterController::class, 'action' => 'create', 'role' => 'guest']);
$this->post('/register', ['path' => RegisterController::class, 'action' => 'store', 'role' => 'guest']);
// login
$this->get('/login', ['path' => LoginController::class, 'action' => 'create', 'role' => 'guest']);
$this->post('/login', ['path' => LoginController::class, 'action' => 'store', 'role' => 'guest']);
$this->delete('/logout', ['path' => LoginController::class, 'action' => 'logout', 'role' => 'user']);
// dashboard          
$this->get('/dashboard', ['path' => DashboardController::class, 'action' => 'index', 'role' => 'user']);
$this->patch('/dashboard/return', ['path' => DashboardController::class, 'action' => 'returnMovie', 'role' => 'user']);
// rentals          
$this->get('/rentals', ['path' => RentalsController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/rentals/show', ['path' => RentalsController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/rentals/edit', ['path' => RentalsController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/rentals/create', ['path' => RentalsController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/rentals', ['path' => RentalsController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/rentals', ['path' => RentalsController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/rentals/destroy', ['path' => RentalsController::class, 'action' => 'destroy', 'role' => 'user']);
// members         
$this->get('/members', ['path' => MembersController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/members/show', ['path' => MembersController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/members/edit', ['path' => MembersController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/members/create', ['path' => MembersController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/members', ['path' => MembersController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/members', ['path' => MembersController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/members/destroy', ['path' => MembersController::class, 'action' => 'destroy', 'role' => 'user']);
// copies          
$this->get('/copies', ['path' => CopiesController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/copies/show', ['path' => CopiesController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/copies/edit', ['path' => CopiesController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/copies/create', ['path' => CopiesController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/copies', ['path' => CopiesController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/copies', ['path' => CopiesController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/copies/destroy', ['path' => CopiesController::class, 'action' => 'destroy', 'role' => 'user']);
// media          
$this->get('/media', ['path' => MediaController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/media/show', ['path' => MediaController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/media/edit', ['path' => MediaController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/media/create', ['path' => MediaController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/media', ['path' => MediaController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/media', ['path' => MediaController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/media/destroy', ['path' => MediaController::class, 'action' => 'destroy', 'role' => 'user']);
// movies          
$this->get('/movies', ['path' => MoviesController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/movies/show', ['path' => MoviesController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/movies/edit', ['path' => MoviesController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/movies/create', ['path' => MoviesController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/movies', ['path' => MoviesController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/movies', ['path' => MoviesController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/movies/destroy', ['path' => MoviesController::class, 'action' => 'destroy', 'role' => 'user']);
// prices           
$this->get('/prices', ['path' => PricesController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/prices/show', ['path' => PricesController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/prices/edit', ['path' => PricesController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/prices/create', ['path' => PricesController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/prices', ['path' => PricesController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/prices', ['path' => PricesController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/prices/destroy', ['path' => PricesController::class, 'action' => 'destroy', 'role' => 'user']);
// genres           
$this->get('/genres', ['path' => GenresController::class, 'action' => 'index', 'role' => 'user']);
$this->get('/genres/show', ['path' => GenresController::class, 'action' => 'show', 'role' => 'user']);
$this->get('/genres/edit', ['path' => GenresController::class, 'action' => 'edit', 'role' => 'user']);
$this->get('/genres/create', ['path' => GenresController::class, 'action' => 'create', 'role' => 'user']);
$this->patch('/genres', ['path' => GenresController::class, 'action' => 'update', 'role' => 'user']);
$this->post('/genres', ['path' => GenresController::class, 'action' => 'store', 'role' => 'user']);
$this->delete('/genres/destroy', ['path' => GenresController::class, 'action' => 'destroy', 'role' => 'user']);