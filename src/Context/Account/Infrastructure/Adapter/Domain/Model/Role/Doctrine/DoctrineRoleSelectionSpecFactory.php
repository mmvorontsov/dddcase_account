<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine;

use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\Role\RoleSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Role\RoleSelectionSpecInterface;

/**
 * Class DoctrineRoleSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine
 */
final class DoctrineRoleSelectionSpecFactory implements RoleSelectionSpecFactoryInterface
{
    /**
     * @param array $permissionIds
     * @return RoleSelectionSpecInterface
     */
    public function createHasOneOfPermissionsSelectionSpec(array $permissionIds): RoleSelectionSpecInterface
    {
        return new DoctrineHasOneOfPermissionsSelectionSpec($permissionIds);
    }

    /**
     * @param string $owner
     * @return RoleSelectionSpecInterface
     */
    public function createBelongsToOwnerSelectionSpec(string $owner): RoleSelectionSpecInterface
    {
        return new DoctrineBelongsToOwnerSelectionSpec($owner);
    }

    /**
     * @param RoleId[] $roleIds
     * @return RoleSelectionSpecInterface
     */
    public function createIsOneOfRoleIdsSelectionSpec(array $roleIds): RoleSelectionSpecInterface
    {
        return new DoctrineIsOneOfRoleIdsSelectionSpec($roleIds);
    }
}
