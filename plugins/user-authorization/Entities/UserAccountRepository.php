<?php

namespace PageManagementSystem\Plugins\UserAuthorization\Entities;

interface UserAccountRepository
{
    public function exists(Username $username): bool;

    public function save(UserAccount $account): void;

    public function get(Username $username): UserAccount;
}
