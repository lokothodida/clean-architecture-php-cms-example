<?php

namespace PageManagementSystem\Plugins\Database\Adapters;

use Exception;
use StdClass;
use PageManagementSystem\Plugins\Database\ViewModel\PageRepository;
use PageManagementSystem\Plugins\Database\ViewModel\Page;
use Zumba\JsonSerializer\JsonSerializer;

class JsonPageViewRepository implements PageRepository
{
    private $directory;
    private $serializer;

    public function __construct(string $directory)
    {
        $this->directory  = $directory;
        $this->serializer = new JsonSerializer();
    }

    public function get(string $slug): Page
    {
        if (!file_exists($this->getFilename($slug))) {
            throw new Exception(sprintf('Page %s does not exist', $slug));
        }

        return $this->jsonToPage($this->getJson($this->getFilename($slug)));
    }

    public function getAll(): array
    {
        return array_map(function (string $filename) {
            return $this->jsonToPage($this->getJson($filename));
        }, glob($this->getFilename('*')));
    }

    private function jsonToPage(StdClass $json): Page
    {
        return new Page(
            $json->slug->slug,
            $json->title->title,
            $json->content->content
        );
    }

    private function getJson(string $filename): StdClass
    {
        return json_decode(file_get_contents($filename));
    }

    private function getFilename(string $slug): string
    {
        return $this->directory . '/' . $slug . '.json';
    }
}
