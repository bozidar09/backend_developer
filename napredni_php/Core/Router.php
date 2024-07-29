<?php

namespace Core;

class Router { 

    private array $routes; 

    public function __construct()
    {
        $this->routes = require_once basePath('config/router_config.php'); 
    }

    public function getPath(string $uri): void
    {       
        if (array_key_exists($uri, $this->routes)) {
            require basePath($this->routes[$uri]); 
        } else {
            abort(404);
        }
    }
}