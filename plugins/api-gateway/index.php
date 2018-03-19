<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

use PageManagementSystem\Plugins\Database\Adapters\PageRepository\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository\JsonPagePresenterRepository;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem\LocalFileSystem;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\ApiGateway\Http\PageViewController;
use PageManagementSystem\Plugins\ApiGateway\Http\JsonResponse;
use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\Request;
use PageManagementSystem\UseCases\UseCaseFactory;

$fileSystem = new LocalFileSystem('/var/tmp/');
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
