<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Security\Client\Client;
use App\Context\Account\Infrastructure\Security\Client\User;
use App\Context\Account\Infrastructure\Security\SecurityInterface;

/**
 * Class SecurityAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class SecurityAddition implements SecurityAdditionInterface
{
    /**
     * @var SecurityInterface
     */
    private SecurityInterface $security;

    /**
     * SecurityAddition constructor.
     * @param SecurityInterface $security
     */
    public function __construct(SecurityInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @return User
     */
    public function getAuthenticatedUserOrForbidden(): User
    {
        $client = $this->getClient();
        if (!$client instanceof User) {
            throw new ForbiddenException();
        }

        return $client;
    }

    /**
     * @param UserId $userId
     */
    public function isAuthenticatedUserIdOrForbidden(UserId $userId): void
    {
        $client = $this->getAuthenticatedUserOrForbidden();
        $authenticatedUserId = UserId::createFrom($client->getId());

        if (!$userId->isEqualTo($authenticatedUserId)) {
            throw new ForbiddenException();
        }
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->security->getClient();
    }
}
