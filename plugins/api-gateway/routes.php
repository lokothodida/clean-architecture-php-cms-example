<?php

use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\ApiGateway\Http\PageViwController;

/** @var App $app */
/** @var PageController $pageController */
/** @var PageViewController $pageViewController */
$app->get('pages/([a-z0-9-]+)', [$pageViewController, 'viewPage']);
$app->get('pages(/)*', [$pageViewController, 'viewAllPages']);
$app->get('', [$pageViewController, 'viewAllPages']);

$app->post('pages(/)*', [$pageController, 'createPage']);
$app->patch('pages/([a-z0-9-]+)', [$pageController, 'updatePage']);
$app->post('pages/([a-z0-9-]+)', [$pageController, 'renameSlug']);
$app->delete('pages/([a-z0-9-]+)', [$pageController, 'deletePage']);

$app->post('register(/)*', [$userController, 'register']);
$app->post('login(/)*', [$userController, 'login']);
$app->post('logout(/)*', [$userController, 'logout']);
