<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine;

use App\Context\Account\Domain\Model\Outbox\OutboxSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineOutboxSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine
 */
interface DoctrineOutboxSelectionSpecInterface extends OutboxSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
