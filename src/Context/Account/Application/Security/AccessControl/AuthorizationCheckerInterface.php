<?php

namespace App\Context\Account\Application\Security\AccessControl;

/**
 * Interface AuthorizationCheckerInterface
 * @package App\Context\Account\Application\Security\AccessControl
 */
interface AuthorizationCheckerInterface
{
    /**
     * @param array $permissions
     * @return bool
     */
    public function can(array $permissions): bool;

    /**
     * @param array $permissions
     * @return bool
     */
    public function canOr(array $permissions): bool;

    /**
     * @param array $roles
     * @return bool
     */
    public function be(array $roles): bool;

    /**
     * @param array $roles
     * @return bool
     */
    public function beOr(array $roles): bool;
}
