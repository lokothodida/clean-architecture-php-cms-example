<?php

namespace PageManagementSystem\Entities;

interface PageRepository
{
    public function get(Slug $slug): Page;

    public function save(Page $page): void;

    public function delete(Slug $slug): void;

    public function exists(Slug $slug): bool;
}
