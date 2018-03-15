<?php

namespace PageManagementSystem\Plugins\Database\Adapters;

use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Page;
use Zumba\JsonSerializer\JsonSerializer;

class JsonPageRepository implements PageRepository
{
    /** @var Page[] */
    private $pages = [];

    /** @var string */
    private $directory;

    /** @var JsonSerializer */
    private $serializer;

    public function __construct(string $directory)
    {
        $this->directory  = $directory;
        $this->serializer = new JsonSerializer();
    }

    public function get(Slug $slug): Page
    {
        if (!$this->exists($slug)) {
            throw new PageDoesNotExist($slug);
        }

        if (!isset($this->pages[(string)$slug])) {
            $this->pages[(string)$slug] = $this->serializer->unserialize(file_get_contents($this->getFilename((string)$slug)));
        }

        return $this->pages[(string)$slug];
    }

    public function save(Page $page): void
    {
        $this->pages[(string)$page->slug()] = $page;

        file_put_contents($this->getFilename((string)$page->slug()), $this->serializer->serialize($page));
    }

    public function delete(Slug $slug): void
    {
        if (!$this->exists($slug)) {
            throw new PageDoesNotExist($slug);
        }

        unlink($this->getFilename((string)$slug));
        unset($this->pages[(string)$slug]);
    }

    public function exists(Slug $slug): bool
    {
        return file_exists($this->getFilename($slug));
    }

    private function getFilename(string $slug): string
    {
        return $this->directory . '/' . $slug . '.json';
    }
}
