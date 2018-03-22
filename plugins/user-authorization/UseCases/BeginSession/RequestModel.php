<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession;

class RequestModel
{
    private $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
