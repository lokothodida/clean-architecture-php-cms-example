<?php

namespace spec\PageManagementSystem\Plugins\ApiGateway\Http;

use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\Request;
use PageManagementSystem\Plugins\ApiGateway\Http\JsonResponse;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\Database\Adapters\PageRepository\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository\JsonPagePresenterRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem\InMemoryFileSystem;
use PageManagementSystem\UseCases\UseCaseFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AppSpec extends ObjectBehavior
{
    /** @var FileSystem */
    private $fileSystem;

    /** @var PageController */
    private $controller;

    public function let()
    {
        $this->fileSystem = new InMemoryFileSystem();
        $this->controller = new PageController(
            new UseCaseFactory(new JsonPageRepository($this->fileSystem)),
            new JsonPagePresenterRepository($this->fileSystem)
        );
    }

    private function loadApp()
    {
        $this->fileSystem->writeTo('test-page.json', json_encode([
            'slug' => 'test-page',
            'title' => 'Test Page',
            'content' => 'Test Content'
        ]));

        $app = $this;
        $controller = $this->controller;
        require __DIR__ . '/../../../routes.php';
    }

    public function it_should_allow_all_pages_to_be_listed()
    {
        $this->loadApp();
        $this->execute('', new Request('GET', []))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                [
                    'slug' => 'test-page',
                    'title' => 'Test Page',
                    'content' => 'Test Content'
                ]
            ]
        ]));
    }

    public function it_should_allow_a_page_to_be_viewed()
    {
        $this->loadApp();
        $this->execute('pages/test-page', new Request('GET', []))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'slug' => 'test-page',
                'title' => 'Test Page',
                'content' => 'Test Content'
            ]
        ]));
    }

    public function it_should_allow_a_page_to_be_created()
    {
        $this->loadApp();
        $this->execute('pages', new Request('POST', [
            'title' => 'New title',
            'content' => 'New content'
        ]))->shouldBeLike(new JsonResponse(201, [
            'data' => [
                'slug' => 'new-title',
            ]
        ]));

        $this->execute('pages/new-title', new Request('GET', [
        ]))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'slug' => 'new-title',
                'title' => 'New title',
                'content' => 'New content'
            ]
        ]));
    }

    public function it_should_allow_a_page_to_be_updated()
    {
        $this->loadApp();
        $this->execute('pages/test-page', new Request('PATCH', [
            'title' => 'New title',
            'content' => 'New content'
        ]))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));

        $this->execute('pages/test-page', new Request('GET', [
        ]))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'slug' => 'test-page',
                'title' => 'New title',
                'content' => 'New content'
            ]
        ]));
    }

    public function it_should_allow_a_slug_to_be_renamed()
    {
        $this->loadApp();
        $this->execute('pages/test-page', new Request('POST', [
            'slug' => 'test-page-2',
        ]))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'slug' => 'test-page-2',
            ]
        ]));

        $this->execute('pages/test-page-2', new Request('GET', [
        ]))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'slug' => 'test-page-2',
                'title' => 'Test Page',
                'content' => 'Test Content'
            ]
        ]));
    }

    public function it_should_allow_a_page_to_be_deleted()
    {
        $this->loadApp();
        $this->execute('pages/test-page', new Request('DELETE', [
            'slug' => 'test-page-2',
        ]))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));

        $this->execute('pages/test-page', new Request('GET', [
            'slug' => 'test-page-2',
        ]))->shouldBeLike(new JsonResponse(404, [
            'data' => [
                'error' => 'Cannot find page "test-page".',
            ]
        ]));
    }
}
