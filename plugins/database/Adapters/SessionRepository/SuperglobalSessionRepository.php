<?php

namespace PageManagementSystem\Plugins\Database\Adapters\SessionRepository;

use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Session;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\SessionDoesNotExist;

class SuperglobalSessionRepository implements SessionRepository
{
    public function exists(): bool
    {
        return !empty(($_SESSION['loggedIn']));
    }

    public function save(Session $session): void
    {
        $_SESSION['loggedIn'] = $session;
    }

    public function delete(): void
    {
        if (!$this->exists()) {
            throw new SessionDoesNotExist();
        }

        unset($_SESSION['loggedIn']);
    }
}
