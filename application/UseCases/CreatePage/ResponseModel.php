<?php

namespace PageManagementSystem\UseCases\CreatePage;

use PageManagementSystem\UseCases\ResponseModel as ResponseModelInterface;

class ResponseModel implements ResponseModelInterface
{
    private $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
