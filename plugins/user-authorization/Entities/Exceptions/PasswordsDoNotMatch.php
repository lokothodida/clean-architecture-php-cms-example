<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions;

use Exception;

class PasswordsDoNotMatch extends Exception
{
    public function __construct()
    {
        parent::__construct('Passwords do not match');
    }
}
