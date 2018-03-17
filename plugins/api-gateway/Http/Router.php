<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

class Router
{
    private $url;

    private $routes = [];

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function add(string $route, callable $callback): void
    {
        $this->routes[$this->routeToRegex($route)] = $callback;
    }

    public function execute(Request $request): JsonResponse
    {
        foreach ($this->routes as $route => $callback) {
            if (preg_match_all($route, $this->url, $matches, PREG_PATTERN_ORDER) > 0) {
                array_shift($matches);

                if (isset($matches[0])) {
                    $args = $matches[0];
                } else {
                    $args = [];
                }

                array_unshift($args, $request);

                return $callback(...$args);
            }
        }

        return new JsonResponse(404, [
            'error' => [
                'message' => 'Endpoint not found'
            ]
        ]);
    }

    private function routeToRegex(string $route): string
    {
        return '#^' . str_replace('/', '\/', $route) . '$#';
    }
}
