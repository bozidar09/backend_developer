<?php

namespace Core;

class Router 
{ 
    private array $routes = [];
    private static ?Router $instance = null;

    public function __construct()
    {
        require_once basePath('config/router_config.php');
    }

    public static function getRouter(): Router
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    private function add(string $uri, array $data, string $method)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $data['path'],
            'action' => $data['action'],
            'role' => $data['role'] ?? null,
        ];
    }

    public function get(string $uri, array $data)
    {
        $this->add($uri, $data, 'GET');
    }

    public function post(string $uri, array $data)
    {
        $this->add($uri, $data, 'POST');
    }

    public function put(string $uri, array $data)
    {
        $this->add($uri, $data, 'PUT');
    }

    public function patch(string $uri, array $data)
    {
        $this->add($uri, $data, 'PATCH');
    }

    public function delete(string $uri, array $data)
    {
        $this->add($uri, $data, 'DELETE');
    }

    private function checkRole($role): void
    {
        if ($role === 'user' && Session::has('user') === false) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Za pristup ostalim stranicama videoteke morate biti prijavljeni."
            ]);
            redirect('/login');
        }

        if ($role === 'guest' && Session::has('user') === true) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Već ste prijavljeni na aplikaciju."
            ]);
            redirect('/dashboard');
        }
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                $classPath = $route['controller'];
                $action = $route['action'];
                $this->checkRole($route['role']);

                $controller = new $classPath();
                $controller->$action();
                exit();
            }
        }     
       abort();
    }
}