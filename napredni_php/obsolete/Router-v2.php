<?php

namespace Core;

class Router 
{ 
    private array $routes = [];
    private static ?Router $instance = null;

    public function __construct()
    {
        $this->routes = require_once basePath('config/router_config.php');
    }

    public static function getRouter(): Router
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                $classPath = $route['path'];
                $function = $route['action'];

                $controller = new $classPath();
                $controller->$function();
                exit();
            }
        }
        
       abort();
    }
}