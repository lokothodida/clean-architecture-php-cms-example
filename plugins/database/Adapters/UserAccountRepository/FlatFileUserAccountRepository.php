<?php

namespace PageManagementSystem\Plugins\Database\Adapters\UserAccountRepository;

use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccountRepository;
use PageManagementSystem\Plugins\UserAuthorization\Entities\Username;
use PageManagementSystem\Plugins\UserAuthorization\Entities\UserAccount;
use PageManagementSystem\Plugins\Database\Adapters\FileSystem;
use Zumba\JsonSerializer\JsonSerializer;

class FlatFileUserAccountRepository implements UserAccountRepository
{
    private $accounts = [];

    private $fileSystem;

    public function __construct(FileSystem $fileSystem)
    {
        if (!$fileSystem->isReadable()) {
            throw new Exception('Cannot read from file system');
        }

        if (!$fileSystem->isWritable()) {
            throw new Exception('Cannot write to file system');
        }

        $this->fileSystem = $fileSystem;
        $this->serializer = new JsonSerializer();
    }

    public function exists(Username $username): bool
    {
        return isset($this->accounts[(string)$username]) || $this->fileSystem->exists($this->getFilename($username));
    }

    public function save(UserAccount $account): void
    {
        $this->accounts[(string)$account->getUsername()] = $account;
        $this->fileSystem->writeTo(
            $this->getFilename($account->getUsername()),
            $this->serializer->serialize($account)
        );
    }

    public function get(Username $username): UserAccount
    {
        if (!$this->exists($username)) {
            throw new UserDoesNotExist($username);
        }

        if (!isset($this->accounts[(string)$username])) {
            $this->accounts[(string)$username] = $this->serializer->unserialize(
                $this->fileSystem->readFrom($this->getFilename($username))
            );
        }

        return $this->accounts[(string)$username];
    }

    private function getFilename(Username $username): string
    {
        return $username;
    }
}
