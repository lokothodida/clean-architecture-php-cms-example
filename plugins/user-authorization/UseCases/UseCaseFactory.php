<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases;

use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount\UseCase as RegisterAccountUseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount\RequestModel as RegisterAccountRequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount\ResponseModel as RegisterAccountResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser\UseCase as AuthenticateUserUseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser\RequestModel as AuthenticateUserRequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser\ResponseModel as AuthenticateUserResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession\UseCase as BeginSessionUseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession\RequestModel as BeginSessionRequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession\ResponseModel as BeginSessionResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession\UseCase as EndSessionUseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession\RequestModel as EndSessionRequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession\ResponseModel as EndSessionResponseModel;

class UseCaseFactory
{
    private $userAccountRepository;
    private $sessionRepository;

    public function __construct(UserAccountRepository $userAccountRepository, SessionRepository $sessionRepository)
    {
        $this->userAccountRepository = $userAccountRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function registerAccount(string $username, string $password): RegisterAccountResponseModel
    {
        return (new RegisterAccountUseCase(
            $this->userAccountRepository
        ))->execute(new RegisterAccountRequestModel($username, $password));
    }

    public function authenticateUser(string $username, string $password): AuthenticateUserResponseModel
    {
        return (new AuthenticateUserUseCase(
            $this->userAccountRepository
        ))->execute(new AuthenticateUserRequestModel($username, $password));
    }

    public function beginSession(string $username): BeginSessionResponseModel
    {
        return (new BeginSessionUseCase($this->sessionRepository))->execute(new BeginSessionRequestModel($username));
    }

    public function endSession(string $username): EndSessionResponseModel
    {
        return (new EndSessionUseCase($this->sessionRepository))->execute(new EndSessionRequestModel($username));
    }
}
