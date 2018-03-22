<?php

namespace spec\PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount\UseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount\RequestModel as RegisterAccountRequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount\ResponseModel as RegisterAccountResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemoryUserAccountRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UseCaseSpec extends ObjectBehavior
{
    private $userAccountRepository;

    public function let()
    {
        $this->userAccountRepository = new InMemoryUserAccountRepository();
        $this->beConstructedWith($this->userAccountRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UseCase::class);
    }

    public function it_should_not_allow_multiple_users_to_register_with_the_same_username()
    {
        $this->execute(new RegisterAccountRequestModel(
            'testuser',
            'password123'
        ));

        $this->shouldThrow(Exception::class)->duringExecute(new RegisterAccountRequestModel(
            'testuser',
            'password456'
        ));
    }

    public function it_should_allow_a_user_to_register_an_account()
    {
        $this->execute(new RegisterAccountRequestModel(
            'testuser',
            'password123'
        ))->shouldBeLike(new RegisterAccountResponseModel(
            'testuser'
        ));
    }
}
