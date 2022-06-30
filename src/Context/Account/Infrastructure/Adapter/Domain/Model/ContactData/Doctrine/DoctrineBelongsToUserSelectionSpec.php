<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine;

use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\User\UserId;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineBelongsToUserSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine
 */
final class DoctrineBelongsToUserSelectionSpec implements DoctrineContactDataSelectionSpecInterface
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * DoctrineBelongsToUserSelectionSpec constructor.
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
        $qb->from(ContactData::class, 'cd')
            ->select('cd')
            ->where($qb->expr()->eq('cd.userId', ':userId'))
            ->setParameter('userId', $this->userId);

        return $qb;
    }
}
