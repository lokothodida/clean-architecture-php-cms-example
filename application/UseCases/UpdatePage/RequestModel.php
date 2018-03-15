<?php

namespace PageManagementSystem\UseCases\UpdatePage;

use PageManagementSystem\UseCases\RequestModel as RequestModelInterface;

class RequestModel implements RequestModelInterface
{
    private $slug;
    private $title;
    private $content;

    public function __construct(string $slug, string $title, string $content)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
