<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine;

use App\Context\Account\Domain\Model\User\UserSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\User\UserSelectionSpecInterface;

/**
 * Class DoctrineUserSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine
 */
final class DoctrineUserSelectionSpecFactory implements UserSelectionSpecFactoryInterface
{
    /**
     * @param array $roleIds
     * @return UserSelectionSpecInterface
     */
    public function createHasOneOfRolesSelectionSpec(array $roleIds): UserSelectionSpecInterface
    {
        return new DoctrineHasOneOfRolesSelectionSpec($roleIds);
    }
}
