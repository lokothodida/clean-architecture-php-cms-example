<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Infrastructure;

use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccount;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Exceptions\UserDoesNotExist;

class InMemoryUserAccountRepository implements UserAccountRepository
{
    private $accounts = [];

    public function exists(Username $username): bool
    {
        return isset($this->accounts[(string)$username]);
    }

    public function save(UserAccount $account): void
    {
        $this->accounts[(string)$account->getUsername()] = $account;
    }

    public function get(Username $username): UserAccount
    {
        if (!$this->exists($username)) {
            throw new UserDoesNotExist($username);
        }

        return $this->accounts[(string)$username];
    }
}
