<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine;

use App\Context\Account\Domain\Model\User\UserSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineUserSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine
 */
interface DoctrineUserSelectionSpecInterface extends UserSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
