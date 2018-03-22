<?php

namespace PageManagementSystem\Plugins\UserAuthorization\UseCases\RegisterAccount;

class ResponseModel
{
    public function __construct(string $username)
    {
        $this->username = $username;
    }
}
