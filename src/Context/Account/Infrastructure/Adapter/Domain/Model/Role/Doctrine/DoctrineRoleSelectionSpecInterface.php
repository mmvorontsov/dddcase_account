<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine;

use App\Context\Account\Domain\Model\Role\RoleSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineRoleSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine
 */
interface DoctrineRoleSelectionSpecInterface extends RoleSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
