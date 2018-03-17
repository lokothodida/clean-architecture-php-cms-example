<?php

namespace PageManagementSystem\Plugins\Database\Adapters\PageRepository;

use Exception;
use StdClass;
use ReflectionClass;
use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Title;
use PageManagementSystem\Entities\Content;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem;
use Zumba\JsonSerializer\JsonSerializer;

class JsonPageRepository implements PageRepository
{
    /** @var FileSystem */
    private $fileSystem;

    /** @var Page[] */
    private $pages = [];

    /** @var JsonSerializer */
    private $serializer;

    public function __construct(FileSystem $fileSystem)
    {
        if (!$fileSystem->isReadable()) {
            throw new Exception('Cannot read from file system');
        }

        if (!$fileSystem->isWritable()) {
            throw new Exception('Cannot write to file system');
        }

        $this->fileSystem = $fileSystem;
        $this->serializer = new JsonSerializer();
    }

    public function get(Slug $slug): Page
    {
        if (!isset($this->pages[(string)$slug])) {
            $this->pages[(string)$slug] = $this->unserialize(
                $this->fileSystem->readFrom($this->getFilename($slug))
            );
        }

        return $this->pages[(string)$slug];
    }

    public function save(Page $page): void
    {
        $this->fileSystem->writeTo($this->getFilename($page->slug()), $this->serialize($page));
        $this->pages[(string)$page->slug()] = $page;
    }

    public function delete(Slug $slug): void
    {
        $this->fileSystem->delete($this->getFilename($slug));
        unset($this->pages[(string)$slug]);
    }

    public function exists(Slug $slug): bool
    {
        return isset($this->pages[(string)$slug]) || $this->fileSystem->exists($this->getFilename($slug));
    }

    private function getFilename(Slug $slug): string
    {
        return $slug . '.json';
    }

    private function serialize(Page $page): string
    {
        $json = json_decode($this->serializer->serialize($page));

        return json_encode([
            'slug' => $json->slug->slug,
            'title' => $json->title->title,
            'content' => $json->content->content,
        ]);
    }

    private function unserialize(string $string): Page
    {
        $json = json_decode($string);

        return $this->serializer->unserialize(json_encode([
            '@type' => Page::class,
            'slug' => [
                '@type' => Slug::class,
                'slug' => $json->slug,
            ],
            'title' => [
                '@type' => Title::class,
                'title' => $json->title
            ],
            'content' => [
                '@type' => Content::class,
                'content' => $json->content
            ]

        ]));
    }
}
