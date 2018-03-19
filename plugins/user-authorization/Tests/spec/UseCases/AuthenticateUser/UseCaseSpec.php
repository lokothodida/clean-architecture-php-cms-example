<?php

namespace spec\PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser;

use Exception;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser\UseCase;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser\RequestModel;
use PageManagementSystem\Plugins\UserAuthorization\UseCases\AuthenticateUser\ResponseModel;
use PageManagementSystem\Plugins\UserAuthorization\Infrastructure\InMemoryUserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccount;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\UserDoesNotExist;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\PasswordsDoNotMatch;
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

    public function it_should_fail_authentication_when_it_cannot_find_the_username()
    {
        $this->shouldThrow(UserDoesNotExist::class)->duringExecute(new RequestModel(
            'testuser',
            'password123'
        ));
    }

    public function it_should_fail_authenticated_when_the_password_does_not_match()
    {
        $this->userAccountRepository->save(UserAccount::register('testuser', 'password123'));

        $this->shouldThrow(PasswordsDoNotMatch::class)->duringExecute(new RequestModel(
            'testuser',
            'password456'
        ));
    }

    public function it_should_allow_users_to_authenticate()
    {
        $this->userAccountRepository->save(UserAccount::register('testuser', 'password123'));

        $this->execute(new RequestModel(
            'testuser',
            'password123'
        ))->shouldBeLike(new ResponseModel());
    }
}
