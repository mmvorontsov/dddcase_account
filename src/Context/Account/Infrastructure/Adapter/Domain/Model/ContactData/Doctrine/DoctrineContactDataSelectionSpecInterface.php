<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine;

use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineContactDataSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine
 */
interface DoctrineContactDataSelectionSpecInterface extends ContactDataSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
