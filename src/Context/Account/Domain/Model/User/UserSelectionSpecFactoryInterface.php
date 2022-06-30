<?php

namespace App\Context\Account\Domain\Model\User;

/**
 * Interface UserSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\User
 */
interface UserSelectionSpecFactoryInterface
{
    /**
     * @param array $roleIds
     * @return UserSelectionSpecInterface
     */
    public function createHasOneOfRolesSelectionSpec(array $roleIds): UserSelectionSpecInterface;
}
