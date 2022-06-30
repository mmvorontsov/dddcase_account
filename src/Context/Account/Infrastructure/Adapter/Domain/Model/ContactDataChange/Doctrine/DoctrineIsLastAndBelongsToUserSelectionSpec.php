<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\User\UserId;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineIsLastAndBelongsToUserSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine
 */
final class DoctrineIsLastAndBelongsToUserSelectionSpec implements DoctrineContactDataChangeSelectionSpecInterface
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * DoctrineIsLastAndBelongsToUserSelectionSpec constructor.
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(ContactDataChange::class, 'cdc')
            ->select('cdc')
            ->where($qb->expr()->eq('cdc.userId', ':userId'))
            ->orderBy('cdc.createdAt', 'DESC')
            ->setParameter('userId', $this->userId);

        return $qb;
    }
}
