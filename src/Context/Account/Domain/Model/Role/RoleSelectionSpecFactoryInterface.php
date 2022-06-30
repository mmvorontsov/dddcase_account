<?php

namespace App\Context\Account\Domain\Model\Role;

/**
 * Interface RoleSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\Role
 */
interface RoleSelectionSpecFactoryInterface
{
    /**
     * @param array $permissionIds
     * @return RoleSelectionSpecInterface
     */
    public function createHasOneOfPermissionsSelectionSpec(array $permissionIds): RoleSelectionSpecInterface;

    /**
     * @param string $owner
     * @return RoleSelectionSpecInterface
     */
    public function createBelongsToOwnerSelectionSpec(string $owner): RoleSelectionSpecInterface;

    /**
     * @param RoleId[] $roleIds
     * @return RoleSelectionSpecInterface
     */
    public function createIsOneOfRoleIdsSelectionSpec(array $roleIds): RoleSelectionSpecInterface;
}
