<?php

namespace PageManagementSystem\Entities;

use PageManagementSystem\Entities\Exceptions\SlugCannotBeEmpty;
use PageManagementSystem\Entities\Exceptions\SlugHasNoAlphanumericCharacters;

class Slug
{
    /** @var string */
    private $slug;

    private function __construct(string $string)
    {
        $slug = $this->stripAllNonAlphanumericCharacters($string);

        if (strlen($slug) === 0) {
            throw new SlugCannotBeEmpty();
        }

        if (!$this->hasAlphanumericCharacter($slug)) {
            throw new SlugHasNoAlphanumericCharacters();
        }

        $this->slug = $slug;
    }

    public static function fromString(string $slug): self
    {
        return new self($slug);
    }

    public function __toString(): string
    {
        return $this->slug;
    }

    private function stripAllNonAlphanumericCharacters(string $string): string
    {
        return preg_replace('/[^0-9a-z]+/', '-', strtolower($string));
    }

    private function hasAlphanumericCharacter(string $slug): bool
    {
        return preg_match('/[0-9a-z]/', $slug);
    }
}
