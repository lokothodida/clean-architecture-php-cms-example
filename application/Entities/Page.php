<?php

namespace PageManagementSystem\Entities;

class Page
{
    private $slug;
    private $title;
    private $content;

    public static function create(string $slug, string $title, string $content)
    {
        return new self(
            Slug::fromString($slug),
            Title::fromString($title),
            Content::fromString($content)
        );
    }

    private function __construct(Slug $slug, Title $title, Content $content)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function renameSlug(Slug $slug)
    {
        $this->slug = $slug;
    }

    public function updateTitle(Title $title)
    {
        $this->title = $title;
    }

    public function updateContent(Content $content)
    {
        $this->content = $content;
    }
}
