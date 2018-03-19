<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities;

class Username
{
    private $username;

    private function __construct(string $username)
    {
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public static function fromString(string $username): self
    {
        return new self($username);
    }
}
