<?php

namespace spec\PageManagementSystem\Plugins\ApiGateway\Http;

use PageManagementSystem\UseCases\UseCaseFactory;

use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\Request;
use PageManagementSystem\Plugins\ApiGateway\Http\JsonResponse;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\ApiGateway\Http\PageViewController;
use PageManagementSystem\Plugins\ApiGateway\Http\UserController;

use PageManagementSystem\Plugins\Database\Adapters\PageRepository\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository\JsonPagePresenterRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem\InMemoryFileSystem;

use PageManagementSystem\Plugins\UserAuthorization\UseCases\UseCaseFactory as UserAuthorizationUseCaseFactory;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemoryUserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemorySessionRepository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AppSpec extends ObjectBehavior
{
    /** @var FileSystem */
    private $fileSystem;

    /** @var PageController */
    private $pageController;

    /** @var PageViewController */
    private $pageViewController;

    private $userAccountRepository;

    private $sessionRepository;

    private $userController;

    private $userAuthorizationUseCaseFactory;

    public function let()
    {
        $this->fileSystem = new InMemoryFileSystem();
        $this->pageController = new PageController(
            new UseCaseFactory(new JsonPageRepository($this->fileSystem))
        );

        $this->pageViewController = new PageViewController(
            new JsonPagePresenterRepository($this->fileSystem)
        );

        $this->sessionRepository = new InMemorySessionRepository();
        $this->userAccountRepository = new InMemoryUserAccountRepository();
        $this->userAuthorizationUseCaseFactory = new UserAuthorizationUseCaseFactory(
            $this->userAccountRepository,
            $this->sessionRepository
        );

        $this->userController = new UserController(
            $this->userAuthorizationUseCaseFactory,
            $this->sessionRepository
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
        $pageController = $this->pageController;
        $pageViewController = $this->pageViewController;
        $userController = $this->userController;
        require __DIR__ . '/../../../routes.php';
    }

    public function it_should_allow_all_pages_to_be_listed()
    {
        $this->loadApp();
        $this->register('testuser', 'password');
        $this->login('testuser', 'password');
        $this->execute('pages', new Request('GET', []))->shouldBeLike(new JsonResponse(200, [
            'data' => [
                [
                    'slug' => 'test-page',
                    'title' => 'Test Page',
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
        $this->register('testuser', 'password');
        $this->login('testuser', 'password');
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
        $this->register('testuser', 'password');
        $this->login('testuser', 'password');
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
        $this->register('testuser', 'password');
        $this->login('testuser', 'password');
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
        $this->register('testuser', 'password');
        $this->login('testuser', 'password');
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

    public function it_should_allow_users_to_register()
    {
        $this->loadApp();
        $this->register('testuser', 'testpassword')->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));
    }

    public function it_should_allow_users_to_log_in()
    {
        $this->loadApp();
        $this->register('testuser', 'testpassword')->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));

        $this->login('testuser', 'testpassword')->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));
    }

    public function it_should_allow_users_to_log_out()
    {
        $this->loadApp();
        $this->register('testuser', 'testpassword')->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));

        $this->login('testuser', 'testpassword')->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));

        $this->logout('testuser')->shouldBeLike(new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]));
    }

    private function register($username, $password)
    {
        return $this->execute('register/', new Request('POST', [
            'username' => $username,
            'password' => $password
        ]));
    }

    private function login($username, $password)
    {
        return $this->execute('login/', new Request('POST', [
            'username' => $username,
            'password' => $password
        ]));
    }

    private function logout($username)
    {
        return $this->execute('logout/', new Request('POST', [
            'username' => $username,
        ]));
    }
}
