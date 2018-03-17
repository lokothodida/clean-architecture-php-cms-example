<?php

require __DIR__ . '/../../application/vendor/autoload.php';
require __DIR__ . '/../database/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

use PageManagementSystem\Plugins\Database\Adapters\JsonPageRepository;
use PageManagementSystem\Plugins\Database\Adapters\JsonPageViewRepository;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\ApiGateway\Http\JsonResponse;
use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\Request;
use PageManagementSystem\UseCases\UseCaseFactory;

$controller = new PageController(
    new UseCaseFactory(new JsonPageRepository('/var/tmp/')),
    new JsonPageViewRepository('/var/tmp/')
);

$app = new App((string)@$_GET['action']);

$app->post('pages(/)*',                [$controller, 'createPage']);
$app->get('pages/([a-z0-9-]+)',    [$controller, 'viewPage']);
$app->patch('pages/([a-z0-9-]+)',  [$controller, 'updatePage']);
$app->post('pages/([a-z0-9-]+)',   [$controller, 'renameSlug']);
$app->delete('pages/([a-z0-9-]+)', [$controller, 'deletePage']);
$app->get('',                      [$controller, 'viewAllPages']);

$response = $app->execute(Request::fromGlobals());

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $header) {
    header($header);
}

exit($response->encode());
