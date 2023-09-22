<?php

declare(strict_types = 1);

namespace App\Model;

use App\Model\Exception\HTTPException;

class Router
{
    private array $routes = [];
    private string $uri;
    private mixed $parameter;

    public function __construct()
    {
        $parameter = $this->splitUriIntoArray($_SERVER['REQUEST_URI']) ?? null;
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->parameter = $parameter[array_key_last($parameter)] ?? null;
    }

    private function callController(
        array $controller,
        mixed $parameter = null
    ): void {
        $class = $controller[0];
        $method = $controller[1];

        $class = new $class();
        $class->$method($parameter);
    }

    public function addRoute(string $uri, array $controller): self
    {
        $this->routes[] = ['uri' => $uri, 'controller' => $controller];

        return $this;
    }

    private function splitUriIntoArray(string $uri): ?array
    {
        return array_values(array_filter(explode('/', $uri)));
    }

    public function run(): void
    {
        foreach ($this->routes as $route) {
            $routeUriArray = $this->splitUriIntoArray($route['uri']);
            $uriArray = $this->splitUriIntoArray($this->uri);

            if ($this->uri === $route['uri'] || $uriArray === $routeUriArray) {
                $this->callController($route['controller']);
                return;
            } else {
                if (empty($uriArray)) {
                    break;
                }

                $routeParameter = $routeUriArray[array_key_last($routeUriArray)]
                    ?? null;

                if (is_string($routeParameter)
                    && mb_substr($routeParameter, 0, 1) === ':') {
                    unset(
                        $uriArray[array_key_last($uriArray)],
                        $routeUriArray[array_key_last($routeUriArray)]
                    );

                    if ($uriArray === $routeUriArray) {
                        $this->callController(
                            $route['controller'],
                            $this->parameter
                        );
                        return;
                    }
                }
            }
        }

        throw new HTTPException(404);
    }
}
