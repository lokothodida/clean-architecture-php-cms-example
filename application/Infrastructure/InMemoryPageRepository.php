<?php

namespace PageManagementSystem\Infrastructure;

use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Exceptions\PageDoesNotExist;

class InMemoryPageRepository implements PageRepository
{
    /** @var Page[] */
    private $pages = [];

    public function get(Slug $slug): Page
    {
        if (!$this->exists($slug)) {
            throw new PageDoesNotExist($slug);
        }

        return $this->pages[(string)$slug];
    }

    public function save(Page $page): void
    {
        $this->pages[(string)$page->slug()] = $page;
    }

    public function delete(Slug $slug): void
    {
        if (!$this->exists($slug)) {
            throw new PageDoesNotExist($slug);
        }

        unset($this->pages[(string)$slug]);
    }

    public function exists(Slug $slug): bool
    {
        return isset($this->pages[(string)$slug]);
    }
}
