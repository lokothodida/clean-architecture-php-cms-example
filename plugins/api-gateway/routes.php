<?php

use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;

/** @var App $app */
/** @var PageController $controller */
$app->post('pages(/)*', [$controller, 'createPage']);
$app->get('pages/([a-z0-9-]+)', [$controller, 'viewPage']);
$app->get('pages(/)*', [$controller, 'viewAllPages']);
$app->patch('pages/([a-z0-9-]+)', [$controller, 'updatePage']);
$app->post('pages/([a-z0-9-]+)', [$controller, 'renameSlug']);
$app->delete('pages/([a-z0-9-]+)', [$controller, 'deletePage']);
$app->get('', [$controller, 'viewAllPages']);
