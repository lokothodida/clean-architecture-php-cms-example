<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

class JsonResponse
{
    private $statusCode;
    private $body;
    private $headers;

    public function __construct(int $statusCode, array $body = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = [
            'Content-Type: application/json'
        ];
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function encode()
    {
        return json_encode($this->body);
    }
}