<?php

namespace PageManagementSystem\Entities\Exceptions;

use Exception;
use PageManagementSystem\Entities\Slug;

class PageDoesNotExist extends Exception
{
    public function __construct(Slug $slug)
    {
        parent::__construct(sprintf("Page '%s' does not exist", (string)$slug));
    }
}
