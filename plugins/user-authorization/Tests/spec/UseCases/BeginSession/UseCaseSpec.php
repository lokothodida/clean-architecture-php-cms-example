<?php

namespace spec\PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession;

use PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession\UseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession\RequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\BeginSession\ResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemorySessionRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\SessionAlreadyStarted;
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

    public function it_should_allow_users_to_start_sessions()
    {
        $this->execute(new RequestModel('testuser'))->shouldBeLike(new ResponseModel());
    }

    public function it_should_not_allow_users_to_begin_sessions_when_already_started()
    {
        $this->execute(new RequestModel('testuser'));

        $this->shouldThrow(SessionAlreadyStarted::class)->duringExecute(new RequestModel('testuser'));
    }
}
