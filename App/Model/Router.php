<?php

declare(strict_types = 1);

namespace App\Model;

use App\Model\Exception\HTTPException;

class Router
{
    private array $routes = [];
    private string $action;
    private ?string $id;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? '';
        $this->id = $_GET['id'] ?? null;
    }

    public function addRoute(string $action, ?string $parameter, array $controller): self
    {
        $this->routes[] = [
            'action' => $action,
            'parameter' => $parameter,
            'controller' => $controller,
        ];

        return $this;
    }

    public function executeAction(array $route): void
    {
        $controller = $route['controller'];
        $class = $controller[0];
        $method = $controller[1];
        $parameter = $route['parameter'];

        $class = new $class();
        $class->$method($this->$parameter ?? null);
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
