<?php

use PageManagementSystem\Plugins\ApiGateway\Http\App;
use PageManagementSystem\Plugins\ApiGateway\Http\PageController;
use PageManagementSystem\Plugins\ApiGateway\Http\PageViewController;

/** @var App $app */
/** @var PageController $pageController */
/** @var PageViewController $pageViewController */
/** @var UserController $userController */
$authenticateBefore = function (callable $action) use ($userController) {
    return function (...$args) use ($action, $userController) {
        $sessionResponse = $userController->checkUserIsLoggedIn($args[0]);

        if ($sessionResponse->getStatusCode() === 401) {
            return $sessionResponse;
        }

        return $action(...$args);
    };
};

$app->get('pages/([a-z0-9-]+)', [$pageViewController, 'viewPage']);
$app->get('pages(/)*', [$pageViewController, 'viewAllPages']);

$app->post('pages(/)*', $authenticateBefore([$pageController, 'createPage']));
$app->patch('pages/([a-z0-9-]+)', $authenticateBefore([$pageController, 'updatePage']));
$app->post('pages/([a-z0-9-]+)', $authenticateBefore([$pageController, 'renameSlug']));
$app->delete('pages/([a-z0-9-]+)', $authenticateBefore([$pageController, 'deletePage']));

$app->post('register(/)*', [$userController, 'register']);
$app->post('login(/)*', [$userController, 'login']);
$app->post('logout(/)*', [$userController, 'logout']);
