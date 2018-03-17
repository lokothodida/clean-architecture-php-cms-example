<?php

namespace PageManagementSystem\Plugins\Database\Adapters;

interface FileSystem
{
    public function isReadable(string $filename): bool;

    public function isWritable(string $filename): bool;

    public function exists(string $filename): bool;

    public function writeTo(string $filename, string $content): void;

    public function readFrom(string $filename): string;

    public function delete(string $filename): void;

    public function listFiles(): array;
}
