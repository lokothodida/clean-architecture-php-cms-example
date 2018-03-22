<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;

class SessionAlreadyStarted extends Exception
{
    public function __construct(Username $username)
    {
        parent::__construct(sprintf('User %s has already started a session', $username));
    }
}
