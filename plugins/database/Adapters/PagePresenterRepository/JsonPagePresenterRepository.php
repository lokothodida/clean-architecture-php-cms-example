<?php

namespace PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository;

use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem;
use PageManagementSystem\Plugins\Database\ViewModel\Page;

class JsonPagePresenterRepository implements PagePresenterRepository
{
    /** @var FileSystem */
    private $fileSystem;

    public function __construct(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function get(string $slug): Page
    {
        return $this->pageFromFilename($this->getFilename($slug));
    }

    public function getAll(): array
    {
        return array_values(array_map([$this, 'pageFromFilename'], $this->getFilenameList()));
    }

    private function getFilenameList()
    {
        return array_filter($this->fileSystem->listFiles(), function (string $filename) {
            return substr($filename, -5, 5) === '.json';
        });
    }

    private function getFilename(string $slug): string
    {
        return $slug . '.json';
    }

    private function pageFromFilename(string $filename): Page
    {
        $json = json_decode($this->fileSystem->readFrom($filename));

        return new Page($json->slug, $json->title, $json->content);
    }
}
