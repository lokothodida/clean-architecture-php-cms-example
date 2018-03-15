<?php

namespace PageManagementSystem\UseCases\DeletePage;

use PageManagementSystem\UseCases\RequestModel as RequestModelInterface;

class RequestModel implements RequestModelInterface
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
