<?php

namespace App\Context\Account\Domain\Model\Role;

use App\Context\Account\Domain\Model\SpecInterface;

/**
 * Interface RoleRepositoryInterface
 * @package App\Context\Account\Domain\Model\Role
 */
interface RoleRepositoryInterface
{
    /**
     * @param Role $role
     */
    public function add(Role $role): void;

    /**
     * @param Role $role
     */
    public function remove(Role $role): void;

    /**
     * @param RoleId $roleId
     * @return Role|null
     */
    public function findById(RoleId $roleId): ?Role;

    /**
     * @param RoleSelectionSpecInterface $spec
     * @return Role[]
     */
    public function selectSatisfying(RoleSelectionSpecInterface $spec): array;
}
