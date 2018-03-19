<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

use PageManagementSystem\Plugins\UserAuthorization\UseCases\UseCaseFactory as UserAuthorizationUseCaseFactory;
use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;

class UserController
{
    private $useCases;
    private $sessionRepository;

    public function __construct(UserAuthorizationUseCaseFactory $useCases, SessionRepository $sessionRepository)
    {
        $this->useCases = $useCases;
        $this->sessionRepository = $sessionRepository;
    }

    public function register(Request $request)
    {
        try {
            $username = $request->input('username');
            $password = $request->input('password');
            $this->useCases->registerAccount($username, $password);

            return new JsonResponse(200, [
                'data' => [
                    'status' => 'Success'
                ]
            ]);
        } catch (Exception $exception) {
            return new JsonResponse(500, [
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $username = $request->input('username');
            $password = $request->input('password');
            $this->useCases->authenticateUser($username, $password);
            $this->useCases->beginSession($username);

            return new JsonResponse(200, [
                'data' => [
                    'status' => 'Success'
                ]
            ]);
        } catch (Exception $exception) {
            return new JsonResponse(500, [
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function checkUserIsLoggedIn($request)
    {
        if (!$this->sessionRepository->exists()) {
            return new JsonResponse(401, [
                'error' => [
                    'message' => 'Must be logged in'
                ]
            ]);
        } else {
            return new JsonResponse(200, [
                'data' => [
                    'message' => 'Success'
                ]
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $username = $request->input('username');
            $this->useCases->endSession($username);

            return new JsonResponse(200, [
                'data' => [
                    'status' => 'Success'
                ]
            ]);
        } catch (Exception $exception) {
            return new JsonResponse(500, [
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }
}
