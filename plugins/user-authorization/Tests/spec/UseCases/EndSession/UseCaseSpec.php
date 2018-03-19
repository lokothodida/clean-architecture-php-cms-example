<?php

namespace spec\PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession;

use PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession\UseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession\RequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\EndSession\ResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemorySessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Session;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\SessionDoesNotExist;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UseCaseSpec extends ObjectBehavior
{
    private $sessionRepository;

    public function let()
    {
        $this->sessionRepository = new InMemorySessionRepository();
        $this->beConstructedWith($this->sessionRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UseCase::class);
    }

    public function it_should_not_allow_users_to_end_sessions_that_havent_started()
    {
        $this->shouldThrow(SessionDoesNotExist::class)->duringExecute(new RequestModel('testuser'));
    }

    public function it_should_allow_users_to_end_sessions()
    {
        $this->sessionRepository->save(Session::begin('testuser'));
        $this->execute(new RequestModel('testuser'))->shouldBeLike(new ResponseModel());
    }
}
