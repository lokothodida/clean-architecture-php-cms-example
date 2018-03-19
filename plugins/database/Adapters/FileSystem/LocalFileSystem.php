<?php

namespace PageManagementSystem\Plugins\Database\Adapters\FileSystem;

use Exception;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem;

class LocalFileSystem implements FileSystem
{
    /** @var string */
    private $baseDirectory;

    public function __construct(string $baseDirectory)
    {
        $this->baseDirectory = $baseDirectory;
    }

    public function isReadable(string $filename = ''): bool
    {
        return is_readable($this->getFilename($filename));
    }

    public function isWritable(string $filename = ''): bool
    {
        return is_writable($this->getFilename($filename));
    }

    public function exists(string $filename): bool
    {
        return file_exists($this->getFilename($filename));
    }

    public function writeTo(string $filename, string $content): void
    {
        if (!@file_put_contents($this->getFilename($filename), $content)) {
            throw new Exception(sprintf('Failed to write to file "%s"', $filename));
        }
    }

    public function readFrom(string $filename): string
    {
        if (($contents = @file_get_contents($this->getFilename($filename))) !== false) {
            return $contents;
        } else {
            throw new Exception(sprintf('File "%s" does not exist', $filename));
        }
    }

    public function delete(string $filename): void
    {
        if (!$this->exists($filename)) {
            throw new Exception(sprintf('File "%s" does not exist', $filename));
        }

        unlink($this->baseDirectory . $filename);
    }

    public function listFiles(): array
    {
        return array_map(function (string $filename) {
            return str_replace($this->baseDirectory, '', $filename);
        }, glob($this->baseDirectory . '*'));
    }

    private function getFilename($filename)
    {
        return $this->baseDirectory . $filename;
    }
}
