<?php

namespace PageManagementSystem\UseCases\Exceptions;

use Exception;
use PageManagementSystem\Entities\Slug;

class SlugAlreadyTaken extends Exception
{
    public function __construct(Slug $slug)
    {
        parent::__construct(sprintf("Page with slug '%s' already exists", (string)$slug));
    }
}
