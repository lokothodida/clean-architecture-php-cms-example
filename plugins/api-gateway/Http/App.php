<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

class App
{
    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    public function get(string $route, callable $callback): void
    {
        $this->routes['GET'][$route] = $callback;
    }

    public function post(string $route, callable $callback): void
    {
        $this->routes['POST'][$route] = $callback;
    }

    public function put(string $route, callable $callback): void
    {
        $this->routes['PUT'][$route] = $callback;
    }

    public function patch(string $route, callable $callback): void
    {
        $this->routes['PATCH'][$route] = $callback;
    }

    public function delete(string $route, callable $callback): void
    {
        $this->routes['DELETE'][$route] = $callback;
    }

    public function execute(string $url, Request $request): JsonResponse
    {
        return $this->setUpRouter($request->getMethod(), $url)->execute($request);
    }

    private function setUpRouter(string $method, string $url): Router
    {
        $router = new Router($url);

        foreach ($this->routes[$method] as $route => $callback) {
            $router->add($route, $callback);
        }

        return $router;
    }
}
