<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities;

class Session
{
    private $username;

    public function __construct(Username $username)
    {
        $this->username = $username;
    }

    public static function begin(string $username): self
    {
        return new self(Username::fromString($username));
    }

    public function getUsername(): Username
    {
        return $this->username;
    }
}
