<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Infrastructure;

use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Session;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\SessionDoesNotExist;

class InMemorySessionRepository implements SessionRepository
{
    private $session;

    public function exists(): bool
    {
        return !empty($this->session);
    }

    public function save(Session $session): void
    {
        $this->session = $session;
    }

    public function delete(): void
    {
        if (!$this->exists()) {
            throw new SessionDoesNotExist();
        }

        unset($this->session);
    }
}
