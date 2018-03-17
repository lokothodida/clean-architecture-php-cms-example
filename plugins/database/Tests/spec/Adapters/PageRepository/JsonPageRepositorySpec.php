<?php

namespace spec\PageManagementSystem\Plugins\Database\Adapters\PageRepository;

use Exception;
use PageManagementSystem\Plugins\Database\Adapters\PageRepository\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem\InMemoryFileSystem;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Title;
use PageManagementSystem\Entities\Content;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonPageRepositorySpec extends ObjectBehavior
{
    private $fileSystem;

    public function let()
    {
        $this->fileSystem = new InMemoryFileSystem();
        $this->beConstructedWith($this->fileSystem);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonPageRepository::class);
    }

    public function it_retreives_pages()
    {
        $slug    = 'test-page';
        $title   = 'Test Page';
        $content = 'Test Content';

        $this->fileSystem->writeTo('test-page.json', json_encode([
            'slug'    => $slug,
            'title'   => $title,
            'content' => $content,
        ]));

        $this->get(Slug::fromString('test-page'))->shouldBeLike(Page::create(
            $slug,
            $title,
            $content
        ));
    }

    public function it_saves_pages()
    {
        $page = Page::create('new-page', 'New Page', 'New Page Content');
        $this->save($page);
        $this->exists($page->slug())->shouldBe(true);
    }

    public function it_retreives_the_same_page_instances()
    {
        $page = Page::create('new-page', 'New Page', 'New Page Content');
        $this->save($page);
        $this->get($page->slug())->shouldBe($page);
    }

    public function it_removes_pages()
    {
        $page = Page::create('new-page', 'New Page', 'New Page Content');
        $this->save($page);
        $this->delete($page->slug());
        $this->shouldThrow(Exception::class)->duringGet($page->slug());
    }
}
