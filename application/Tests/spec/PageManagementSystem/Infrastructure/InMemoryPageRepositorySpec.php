<?php

namespace spec\PageManagementSystem\Infrastructure;

use PageManagementSystem\Infrastructure\InMemoryPageRepository;
use PageManagementSystem\Entities\Page;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryPageRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryPageRepository::class);
    }

    public function it_saves_pages()
    {
        $page = Page::create('new-page', 'New Page', 'New Page Content');
        $this->save($page);
    }

    public function it_retreives_the_same_page_instances()
    {
        $page = Page::create('new-page', 'New Page', 'New Page Content');
        $this->save($page);
        $this->get($page->slug())->shouldBeLike($page);
    }
}
