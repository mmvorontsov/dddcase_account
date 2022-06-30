<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\Security\AccessControl\AuthorizationCheckerInterface;

/**
 * Interface AuthorizationCheckerAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface AuthorizationCheckerAdditionInterface
{
    /**
     * @param array $permissions
     * @return bool
     */
    public function canOrForbidden(array $permissions): bool;

    /**
     * @param array $permissions
     * @return bool
     */
    public function can(array $permissions): bool;

    /**
     * @param array $roles
     * @return bool
     */
    public function beOr(array $roles): bool;
}
