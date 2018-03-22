<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession;

use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Session;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\SessionAlreadyStarted;

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

        if ($this->sessionRepository->exists($username)) {
            throw new SessionAlreadyStarted($username);
        }

        $session = Session::begin($username);
        $this->sessionRepository->save($session);

        return new ResponseModel();
    }
}
