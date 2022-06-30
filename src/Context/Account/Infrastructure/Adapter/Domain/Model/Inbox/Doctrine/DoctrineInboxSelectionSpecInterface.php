<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Inbox\Doctrine;

use App\Context\Account\Domain\Model\Inbox\InboxSelectionSpecInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineInboxSelectionSpecInterface
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Inbox\Doctrine
 */
interface DoctrineInboxSelectionSpecInterface extends InboxSelectionSpecInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder;
}
