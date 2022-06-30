<?php

namespace App\Context\Account\Domain\Model\Permission\Remove;

use App\Context\Account\Domain\Model\Permission\Permission;

/**
 * Interface RemovePermissionServiceInterface
 * @package App\Context\Account\Domain\Model\Permission\Remove
 */
interface RemovePermissionServiceInterface
{
    /**
     * @param Permission $permission
     */
    public function execute(Permission $permission): void;

    /**
     * @param array $permissions
     */
    public function executeForAll(array $permissions): void;
}
