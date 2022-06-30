<?php

namespace App\Context\Account\Domain\Model\Permission;

/**
 * Interface PermissionRepositoryInterface
 * @package App\Context\Account\Domain\Model\Permission
 */
interface PermissionRepositoryInterface
{
    /**
     * @param Permission $permission
     */
    public function add(Permission $permission): void;

    /**
     * @param Permission $permission
     */
    public function remove(Permission $permission): void;

    /**
     * @param PermissionId $permissionId
     * @return Permission|null
     */
    public function findById(PermissionId $permissionId): ?Permission;

    /**
     * @param PermissionSelectionSpecInterface $spec
     * @return array
     */
    public function selectSatisfying(PermissionSelectionSpecInterface $spec): array;
}
