<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;

class UserDoesNotExist extends Exception
{
    public function __construct(Username $username)
    {
        parent::__construct(sprintf('User with username %s does not exist', $username));
    }
}
