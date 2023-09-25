<?php

declare(strict_types = 1);

namespace App\Model;

use App\Model\Exception\HTTPException;

class Router
{
    private array $routes = [];
    private string $action;
    private array $parameters = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? '';

        foreach ($_GET as $key => $value) {
            $this->parameters[$key] = $value;
        }
    }

    public function addRoute(string $action, array $controller): self
    {
        $this->routes[] = [
            'action' => $action,
            'controller' => $controller,
        ];

        return $this;
    }

    public function executeAction(array $route): void
    {
        $controller = $route['controller'];
        $class = $controller[0];
        $method = $controller[1];

        $class = new $class();
        $class->$method($this->parameters ?? null);
    }

    public function run(): void
    {
        foreach ($this->routes as $route) {
            if ($this->action === preg_replace('@^/@', '', $route['action'])) {
                $this->executeAction($route);
                return;
            }
        }

        throw new HTTPException(404);
    }
}
