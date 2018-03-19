<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccount;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\UserDoesNotExist;

class UseCase
{
    private $repository;

    public function __construct(UserAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RequestModel $request): ResponseModel
    {
        $userAccount = $this->repository->get(Username::fromString($request->getUsername()));
        $userAccount->verifyPassword($request->getPassword());

        return new ResponseModel((string)$userAccount->getUsername());
    }
}
