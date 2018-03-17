<?php

namespace PageManagementSystem\Plugins\Database\Adapters\FileSystem;

use Exception;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem;

class InMemoryFileSystem implements FileSystem
{
    private $files = [];

    public function isReadable(string $filename = ''): bool
    {
        return true;
    }

    public function isWritable(string $filename = ''): bool
    {
        return true;
    }

    public function exists(string $filename): bool
    {
        return isset($this->files[$filename]);
    }

    public function writeTo(string $filename, string $content): void
    {
        $this->files[$filename] = $content;
    }

    public function readFrom(string $filename): string
    {
        if (isset($this->files[$filename])) {
            return $this->files[$filename];
        } else {
            throw new Exception(sprintf('File "%s" does not exist', $filename));
        }
    }

    public function delete(string $filename): void
    {
        unset($this->files[$filename]);
    }

    public function listFiles(): array
    {
        return array_keys($this->files);
    }
}
