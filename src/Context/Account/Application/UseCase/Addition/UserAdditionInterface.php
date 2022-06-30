<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface UserAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface UserAdditionInterface
{
    /**
     * @param UserId $id
     * @param string|null $msg
     * @return bool
     */
    public function repositoryContainsIdOrNotFound(UserId $id, string $msg = null): bool;

    /**
     * @param UserId $id
     * @return bool
     */
    public function repositoryContainsIdOrForbidden(UserId $id): bool;

    /**
     * @param UserId $id
     * @return User|null
     */
    public function findById(UserId $id): ?User;

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return User
     */
    public function findByIdOrNotFound(UserId $id, string $msg = null): User;
}
