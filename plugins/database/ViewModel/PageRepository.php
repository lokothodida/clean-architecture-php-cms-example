<?php

namespace PageManagementSystem\Plugins\Database\ViewModel;

interface PageRepository
{
    public function get(string $slug): Page;
}
