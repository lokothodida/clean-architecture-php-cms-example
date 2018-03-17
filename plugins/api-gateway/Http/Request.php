<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

class Request
{
    private $method;
    private $inputs;

    public function __construct(string $method, array $inputs)
    {
        $this->method = $method;
        $this->inputs = $inputs;
    }

    public static function fromGlobals(): self
    {
        return new self(
            $_SERVER['REQUEST_METHOD'],
            (array)json_decode(file_get_contents('php://input'), true)
        );
    }

    public function input($key, $default = null)
    {
        if (isset($this->inputs[$key])) {
            return $this->inputs[$key];
        } else {
            return $default;
        }
    }

    public function getMethod()
    {
        return $this->method;
    }
}
