<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine;

use App\Context\Account\Domain\Model\Registration\Registration;
use DateTimeImmutable;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineIsExpiredSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine
 */
final class DoctrineIsExpiredSelectionSpec implements DoctrineRegistrationSelectionSpecInterface
{
    /**
     * @var int
     */
    private int $limit;

    /**
     * DoctrineIsExpiredSelectionSpec constructor.
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
        $qb->from(Registration::class, 'r')
            ->select('r')
            ->orderBy('r.createdAt', 'ASC')
            ->where('r.expiredAt < :now')
            ->setParameter('now', new DateTimeImmutable())
            ->setMaxResults($this->limit);

        return $qb;
    }
}
