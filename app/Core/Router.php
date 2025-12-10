<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function add($method, $route, $action)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'route'  => $route,
            'action' => $action
        ];
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];

        $uri = strtok($uri, '?');

        $basePath = '/workalign';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '') {
            $uri = '/';
        }

        $request = new Request();
        $currentUri = $uri; 
        $currentMethod = $request->method();

        foreach ($this->routes as $route) {
            if ($route['route'] === $currentUri && $route['method'] === $currentMethod) {

                list($controller, $method) = explode('@', $route['action']);

                $controller = "App\\Controllers\\$controller";

                if (!class_exists($controller)) {
                    Response::json(['error' => 'Controller not found'], 500);
                }

                $instance = new $controller();

                return $instance->$method($request);
            }
        }

        Response::json(['error' => 'Route not found'], 404);
    }
}
