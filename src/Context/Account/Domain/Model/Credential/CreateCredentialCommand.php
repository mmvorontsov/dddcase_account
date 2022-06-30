<?php

namespace App\Context\Account\Domain\Model\Credential;

use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class CreateCredentialCommand
 * @package App\Context\Account\Domain\Model\Credential
 */
final class CreateCredentialCommand
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var string
     */
    private string $hashedPassword;

    /**
     * CreateCredentialCommand constructor.
     * @param UserId $userId
     * @param string|null $username
     * @param string $hashedPassword
     */
    public function __construct(UserId $userId, ?string $username, string $hashedPassword)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}
