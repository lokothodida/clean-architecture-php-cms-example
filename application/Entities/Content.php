<?php

namespace PageManagementSystem\Entities;

class Content
{
    private $content;

    private function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->content;
    }

    public static function fromString(string $content)
    {
        return new self($content);
    }
}
