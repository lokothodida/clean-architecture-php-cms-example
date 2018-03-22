<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;

class SessionDoesNotExist extends Exception
{
    public function __construct()
    {
        parent::__construct('Session does not exist');
    }
}
