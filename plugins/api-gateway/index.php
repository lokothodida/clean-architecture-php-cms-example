<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

use PageManagementSystem\Plugins\Database\Adapters\PageRepository\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\UserAccountRepository\FlatFileUserAccountRepository;
use PageManagementSystem\Plugins\Database\Adapters\SessionRepository\SuperglobalSessionRepository;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository\JsonPagePresenterRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem\LocalFileSystem;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
<<<<<<< HEAD
use PageManagementSystem\Plugins\ApiGateway\Http\PageViewController;
=======
use PageManagementSystem\Plugins\ApiGateway\Http\UserController;
>>>>>>> ed86893... Initial stab at user authorization
use PageManagementSystem\Plugins\ApiGateway\Http\JsonResponse;
use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\Request;
use PageManagementSystem\UseCases\UseCaseFactory;

use PageManagementSystem\Plugins\UserAuthorization\UseCases\UseCaseFactory as UserAuthorizationUseCaseFactory;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemoryUserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemorySessionRepository;

session_start();

$fileSystem = new LocalFileSystem('/var/tmp/');
$sessionRepository = new SuperglobalSessionRepository();
$userController = new UserController(
    new UserAuthorizationUseCaseFactory(
        new FlatFileUserAccountRepository($fileSystem),
        $sessionRepository
    )
);
$pageController = new PageController(new UseCaseFactory(new JsonPageRepository($fileSystem)));
$pageViewController = new PageViewController(new JsonPagePresenterRepository($fileSystem));

$app = new App();

require 'routes.php';

$response = $app->execute((string)@$_GET['action'], Request::fromGlobals());

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $header) {
    header($header);
}

exit($response->encode());
