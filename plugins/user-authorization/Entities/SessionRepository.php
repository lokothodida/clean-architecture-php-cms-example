<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities;

interface SessionRepository
{
    public function exists(): bool;
    public function save(Session $session): void;
    public function delete(): void;
}
