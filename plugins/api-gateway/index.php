<?php

require __DIR__ . '/../../application/vendor/autoload.php';
require __DIR__ . '/../database/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

use PageManagementSystem\Plugins\Database\Adapters\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\JsonPageViewRepository;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\ApiGateway\Http\JsonResponse;
use PageManagementSystem\UseCases\UseCaseFactory;

$controller = new PageController(
    new UseCaseFactory(new JsonPageRepository('/var/tmp/')),
    new JsonPageViewRepository('/var/tmp/')
);

try {
    switch ([@$_GET['action'], @$_POST['action']]) {
        case ['view-page', false]:
            $response = $controller->viewPage($_GET['slug']);
            break;
        case ['create-page', 'create-page']:
            $response = $controller->createPage($_POST['title'], $_POST['content']);
            break;
        case ['update-page', 'update-page']:
            $response = $controller->updatePage($_GET['slug'], $_POST['title'], $_POST['content']);
            break;
        case ['rename-slug', 'rename-slug']:
            $response = $controller->renameSlug($_GET['slug'], $_POST['slug']);
            break;
        case ['delete-page', 'delete-page']:
            $response = $controller->deletePage($_GET['slug']);
            break;
        case [false, false]:
            $response = $controller->viewAllPages();
            break;
        default:
            $response = new JsonResponse(400, [
                'error' => [
                    'message' => 'Endpoint does not exist'
                ]
            ]);
    }
} catch (Exception $exception) {
    $response = new JsonResponse(400, [
        'error' => [
            'message' => $exception->getMessage()
        ]
    ]);
}

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $header) {
    header($header);
}

exit($response->encode());
