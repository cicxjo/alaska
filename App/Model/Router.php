<?php

declare(strict_types = 1);

namespace App\Model;

class Router
{

    private array $routes = [];
    private string $uri;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function addRoute(string $uri, array $controller): self
    {
        $this->routes[] = ['uri' => $uri, 'controller' => $controller];

        return $this;
    }

    private function matchSimpleRoute(array $route): bool
    {
        return $route['uri'] === $this->uri;
    }

    private function callController(array $controller): void
    {
        $class = $controller[0];
        $method = $controller[1];

        $class = new $class();
        $class->$method();
    }

    public function run(): void
    {
        foreach ($this->routes as $route) {
            if ($this->matchSimpleRoute($route)) {
                $this->callController($route['controller']);
                return;
            }
        }
    }
}
