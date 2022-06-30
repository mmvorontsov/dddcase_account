<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine;

use App\Context\Account\Domain\Model\Registration\RegistrationSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineRegistrationSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine
 */
interface DoctrineRegistrationSelectionSpecInterface extends RegistrationSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
