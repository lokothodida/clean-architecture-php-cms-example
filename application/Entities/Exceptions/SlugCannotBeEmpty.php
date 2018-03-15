<?php

namespace PageManagementSystem\Entities\Exceptions;

use Exception;

class SlugCannotBeEmpty extends Exception
{
    public function __construct()
    {
        parent::__construct("Slugs cannot be empty");
    }
}
