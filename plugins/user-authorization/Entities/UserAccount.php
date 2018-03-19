<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities;

use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\PasswordsDoNotMatch;

class UserAccount
{
    private $username;
    private $password;

    private function __construct(Username $username, Password $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function register(string $username, string $password): self
    {
        return new self(
            Username::fromString($username),
            Password::fromString($password)
        );
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function verifyPassword(string $password): void
    {
        if (!$this->password->verify($password)) {
            throw new PasswordsDoNotMatch();
        }
    }
}
