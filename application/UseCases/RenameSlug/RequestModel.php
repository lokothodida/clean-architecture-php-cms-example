<?php

namespace PageManagementSystem\UseCases\RenameSlug;

use PageManagementSystem\UseCases\RequestModel as RequestModelInterface;

class RequestModel implements RequestModelInterface
{
    private $oldSlug;
    private $newSlug;

    public function __construct(string $oldSlug, string $newSlug)
    {
        $this->oldSlug = $oldSlug;
        $this->newSlug = $newSlug;
    }

    public function getOldSlug(): string
    {
        return $this->oldSlug;
    }

    public function getNewSlug(): string
    {
        return $this->newSlug;
    }
}
