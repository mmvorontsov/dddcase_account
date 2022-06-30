<?php

namespace App\Context\Account\Domain\Model\Permission;

/**
 * Interface PermissionSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\Permission
 */
interface PermissionSelectionSpecFactoryInterface
{
    /**
     * @param string $owner
     * @return PermissionSelectionSpecInterface
     */
    public function createBelongsToOwnerSelectionSpec(string $owner): PermissionSelectionSpecInterface;
}
