<?php

namespace App\Context\Account\Domain\Model\Credential\Update;

/**
 * Class UpdateCredentialCommand
 * @package App\Context\Account\Domain\Model\Credential\Update
 */
final class UpdateCredentialCommand
{
    public const HASHED_PASSWORD = 'HASHED_PASSWORD';
    public const USERNAME = 'USERNAME';

    /**
     * @var array<string, array>
     */
    private array $data = [];

    /**
     * @param string $hashedPassword
     */
    public function setHashedPassword(string $hashedPassword): void
    {
        $this->data[self::HASHED_PASSWORD] = [$hashedPassword];
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->data[self::USERNAME] = [$username];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
