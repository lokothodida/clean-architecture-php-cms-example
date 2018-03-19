<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities;

class Password
{
    private $password;

    private function __construct(string $password)
    {
        $this->password = $this->hash($password);
    }

    public function __toString(): string
    {
        return $this->password;
    }

    public function verify(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }

    private function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
