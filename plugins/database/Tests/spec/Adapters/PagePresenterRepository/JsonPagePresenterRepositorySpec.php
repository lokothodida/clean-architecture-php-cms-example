<?php

namespace spec\PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository;

use Exception;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository\JsonPagePresenterRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem\InMemoryFileSystem;
use PageManagementSystem\Plugins\Database\ViewModel\Page;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonPagePresenterRepositorySpec extends ObjectBehavior
{
    private $fileSystem;

    public function let()
    {
        $this->fileSystem = new InMemoryFileSystem();
        $this->beConstructedWith($this->fileSystem);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonPagePresenterRepository::class);
    }

    public function it_should_fail_to_retreive_non_existent_pages()
    {
        $this->shouldThrow(Exception::class)->duringGet('test-page');
    }

    public function it_should_retrieve_a_single_page()
    {
        $this->fileSystem->writeTo('test-page.json', json_encode([
            'slug' => 'test-page',
            'title' => 'Test Page',
            'content' => 'Test Content'
        ]));

        $this->get('test-page')->shouldBeLike(new Page('test-page', 'Test Page', 'Test Content'));
    }

    public function it_should_retrieve_a_collection_of_pages()
    {
        $this->fileSystem->writeTo('test-page.json', json_encode([
            'slug' => 'test-page',
            'title' => 'Test Page',
            'content' => 'Test Content'
        ]));

        $this->fileSystem->writeTo('test-page-2.json', json_encode([
            'slug' => 'test-page-2',
            'title' => 'Test Page 2',
            'content' => 'Test Content 2'
        ]));

        $this->getAll()->shouldBeLike([
            new Page('test-page', 'Test Page', 'Test Content'),
            new Page('test-page-2', 'Test Page 2', 'Test Content 2')
        ]);
    }

    public function it_should_ignore_non_json_files_in_a_collection()
    {
        $this->fileSystem->writeTo('test-page.txt', 'Test Page');
        $this->getAll()->shouldBeLike([]);
    }
}
