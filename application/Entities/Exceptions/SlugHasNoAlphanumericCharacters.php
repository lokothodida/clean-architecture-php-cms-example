<?php

namespace PageManagementSystem\Entities\Exceptions;

use Exception;

class SlugHasNoAlphanumericCharacters extends Exception
{
    public function __construct()
    {
        parent::__construct("Slug has no alphanumeric characters");
    }
}
