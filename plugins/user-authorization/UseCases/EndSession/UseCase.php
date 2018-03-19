<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession;

use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;

class UseCase
{
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function execute(RequestModel $request): ResponseModel
    {
        $username = Username::fromString($request->getUsername());

        $this->sessionRepository->delete($username);

        return new ResponseModel();
    }
}
