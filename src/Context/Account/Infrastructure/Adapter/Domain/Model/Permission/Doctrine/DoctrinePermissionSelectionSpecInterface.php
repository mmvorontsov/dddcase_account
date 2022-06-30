<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine;

use App\Context\Account\Domain\Model\Permission\PermissionSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrinePermissionSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine
 */
interface DoctrinePermissionSelectionSpecInterface extends PermissionSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
