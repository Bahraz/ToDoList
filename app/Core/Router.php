<?php
namespace Bahraz\ToDoApp\Core;

class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    private function normalizePath(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }

    public function get(string $path, string $controllerAction): void
    {
        $this->routes['GET'][$this->normalizePath($path)] = $controllerAction;
    }

    public function post(string $path, string $controllerAction): void
    {
        $this->routes['POST'][$this->normalizePath($path)] = $controllerAction;
    }

    public function patch(string $path, string $controllerAction): void
    {
        $this->routes['PATCH'][$this->normalizePath($path)] = $controllerAction;
    }

    public function delete(string $path, string $controllerAction): void
    {
        $this->routes['DELETE'][$this->normalizePath($path)] = $controllerAction;
    }

    public function dispatch(string $uri): void
    {
        $path = $this->normalizePath(parse_url($uri, PHP_URL_PATH));
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] ?? [] as $route => $controllerAction) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                [$controllerName, $action] = explode('@', $controllerAction);

                $controllerClass = "Bahraz\\ToDoApp\\Controllers\\$controllerName";
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        $controller->$action(...$matches);
                        return;
                    }
                }
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
