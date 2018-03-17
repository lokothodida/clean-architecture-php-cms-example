<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

class App
{
    private $get;
    private $post;
    private $put;
    private $delete;

    public function __construct(string $url)
    {
        $this->get    = new Router($url);
        $this->post   = new Router($url);
        $this->put    = new Router($url);
        $this->patch  = new Router($url);
        $this->delete = new Router($url);
    }

    public function get(string $route, callable $callback): void
    {
        $this->get->add($route, $callback);
    }

    public function post(string $route, callable $callback): void
    {
        $this->post->add($route, $callback);
    }

    public function put(string $route, callable $callback): void
    {
        $this->put->add($route, $callback);
    }

    public function patch(string $route, callable $callback): void
    {
        $this->patch->add($route, $callback);
    }

    public function delete(string $route, callable $callback): void
    {
        $this->delete->add($route, $callback);
    }

    public function execute(Request $request): JsonResponse
    {
        switch ($request->getMethod()) {
            case 'POST':
                return $this->post->execute($request);
            case 'PUT':
                return $this->put->execute($request);
            case 'PATCH':
                return $this->patch->execute($request);
            case 'DELETE':
                return $this->delete->execute($request);
            default:
                return $this->get->execute($request);
        }
    }
}
