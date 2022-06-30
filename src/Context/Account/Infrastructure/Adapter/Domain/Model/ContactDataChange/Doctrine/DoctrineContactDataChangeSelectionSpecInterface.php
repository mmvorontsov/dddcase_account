<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineContactDataChangeSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine
 */
interface DoctrineContactDataChangeSelectionSpecInterface extends ContactDataChangeSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
