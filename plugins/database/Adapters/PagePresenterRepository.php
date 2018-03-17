<?php

namespace PageManagementSystem\Plugins\Database\Adapters;

use PageManagementSystem\Plugins\Database\ViewModel\Page;

interface PagePresenterRepository
{
    public function get(string $slug): Page;

    public function getAll(): array;
}
