<?php
namespace Bahraz\SettlersWars\Core;

class Router
{
    protected array $routes = [];

    public function get(string $path, string $controllerAction): void
    {
        $this->routes['GET'][$this->normalizePath($path)] = $controllerAction;
    }

    public function dispatch(string $uri): void
    {
        $path = $this->normalizePath(parse_url($uri, PHP_URL_PATH));
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$path])) {
            [$controllerName, $action] = explode('@', $this->routes[$method][$path]);

            $controllerClass = "Bahraz\\SettlersWars\\Controllers\\$controllerName";
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function normalizePath(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }
}
