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

    private function transformUriToArray(string $uri): array
    {
        return array_values(array_filter(explode('/', $uri)));
    }

    private function extractParameters(array $route): array
    {
        $uri = $this->transformUriToArray($this->uri);
        $route = $this->transformUriToArray($route['uri']);

        array_shift($uri);
        array_shift($route);

        foreach ($route as $key => $value) {
            $value = str_replace(':', '', $value);
            $parameters[$value] = $uri[$key];
        }

        return $parameters; // associative array
    }

    private function matchSimpleRoute(array $route): bool
    {
        return $route['uri'] === $this->uri;
    }

    private function matchComplexRoute(array $route): bool
    {
        $uri = $this->transformUriToArray($this->uri);
        $route = $this->transformUriToArray($route['uri']);

        return count($uri) === count($route) && $uri[0] === $route[0];
    }

    private function callController(array $controller, array $args = []): void
    {
        $class = $controller[0];
        $method = $controller[1];

        $class = new $class();
        $class->$method($args);
    }

    public function run(): void
    {
        foreach ($this->routes as $route) {
            if ($this->matchSimpleRoute($route)) {
                $this->callController($route['controller']);
                return;
            } elseif ($this->matchComplexRoute($route)) {
                $parameters = $this->extractParameters($route);
                $this->callController($route['controller'], $parameters);
                return;
            }
        }
    }
}
