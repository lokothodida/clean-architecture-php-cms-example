<?php

namespace spec\PageManagementSystem\Entities;

use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Slug;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('create', [
            'my-test-page',
            'Test Page',
            'Test page content'
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Page::class);
    }

    public function it_should_allow_slugs_to_be_renamed()
    {
        $this->renameSlug(Slug::fromString('new-slug'));
        $this->slug()->shouldBeLike(Slug::fromString('new-slug'));
    }
}
