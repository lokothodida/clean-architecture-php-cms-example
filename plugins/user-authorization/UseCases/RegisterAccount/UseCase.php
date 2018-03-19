<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccount;

class UseCase
{
    private $repository;

    public function __construct(UserAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RequestModel $request): ResponseModel
    {
        if ($this->repository->exists(Username::fromString($request->getUsername()))) {
            throw new Exception(sprintf('User with username %s already exists', $request->getUsername()));
        }

        $userAccount = UserAccount::register($request->getUsername(), $request->getPassword());

        $this->repository->save($userAccount);

        return new ResponseModel((string)$userAccount->getUsername());
    }
}
