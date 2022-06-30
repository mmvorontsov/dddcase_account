<?php

namespace App\Context\Account\Domain\Model\Role\Remove;

use App\Context\Account\Domain\Model\Role\Role;

/**
 * Interface RemoveRoleServiceInterface
 * @package App\Context\Account\Domain\Model\Role\Remove
 */
interface RemoveRoleServiceInterface
{
    /**
     * @param Role $role
     */
    public function execute(Role $role): void;

    /**
     * @param Role[] $roles
     */
    public function executeForAll(array $roles): void;
}
