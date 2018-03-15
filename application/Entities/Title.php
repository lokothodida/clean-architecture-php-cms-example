<?php

namespace PageManagementSystem\Entities;

class Title
{
    private $title;

    private function __construct(string $title)
    {
        $this->title = $title;
    }

    public function __toString()
    {
        return $this->title;
    }

    public static function fromString(string $title)
    {
        return new self($title);
    }
}
