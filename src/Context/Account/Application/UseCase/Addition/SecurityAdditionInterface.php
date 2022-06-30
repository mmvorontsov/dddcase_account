<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Security\Client\Client;
use App\Context\Account\Infrastructure\Security\Client\User;

/**
 * Interface SecurityAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface SecurityAdditionInterface
{
    /**
     * @return User
     */
    public function getAuthenticatedUserOrForbidden(): User;

    /**
     * @param UserId $userId
     */
    public function isAuthenticatedUserIdOrForbidden(UserId $userId): void;

    /**
     * @return Client|null
     */
    public function getClient(): ?Client;
}
