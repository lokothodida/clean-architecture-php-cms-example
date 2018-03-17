<?php

namespace PageManagementSystem\Plugins\Database\ViewModel;

class Page
{
    /** @var string */
    private $slug;

    /** @var string */
    private $title;

    /** @var string */
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
