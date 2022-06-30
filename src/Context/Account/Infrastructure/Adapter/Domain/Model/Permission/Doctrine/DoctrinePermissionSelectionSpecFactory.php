<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine;

use App\Context\Account\Domain\Model\Permission\PermissionSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Permission\PermissionSelectionSpecInterface;

/**
 * Class DoctrinePermissionSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine
 */
final class DoctrinePermissionSelectionSpecFactory implements PermissionSelectionSpecFactoryInterface
{
    /**
     * @param string $owner
     * @return PermissionSelectionSpecInterface
     */
    public function createBelongsToOwnerSelectionSpec(string $owner): PermissionSelectionSpecInterface
    {
        return new DoctrineBelongsToOwnerSelectionSpec($owner);
    }
}
