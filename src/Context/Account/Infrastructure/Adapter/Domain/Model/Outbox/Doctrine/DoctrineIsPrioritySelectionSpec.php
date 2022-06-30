<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine;

use App\Context\Account\Domain\Model\Outbox\Outbox;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineIsPrioritySelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine
 */
final class DoctrineIsPrioritySelectionSpec implements DoctrineOutboxSelectionSpecInterface
{
    /**
     * @var int
     */
    private int $limit;

    /**
     * DoctrineIsPrioritySelectionSpec constructor.
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(Outbox::class, 'o')
            ->select('o')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults($this->limit);

        return $qb;
    }
}
