<?php

namespace WebApp;

use Exception;

/**
 * Class Router
 * @package WebApp
 */
class Router
{
    /** @var array  */
    protected array $routes = [];

    /**
     * @param $route
     * @param $controller
     * @param $action
     * @param $method
     */
    private function addRoute($route, $controller, $action, $method): void
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * @param $route
     * @param $controller
     * @param $action
     */
    public function get($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    /**
     * @param $route
     * @param $controller
     * @param $action
     */
    public function post($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    /**
     * @throws Exception
     */
    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            throw new Exception("No route found for URI: $uri");
        }
    }
}