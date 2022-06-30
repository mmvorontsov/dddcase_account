<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine;

use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\User\UserId;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineBelongsToUserSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine
 */
final class DoctrineBelongsToUserSelectionSpec implements DoctrineCredentialSelectionSpecInterface
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
        $qb->from(Credential::class, 'c')
            ->select('c')
            ->where($qb->expr()->eq('c.userId', ':userId'))
            ->setParameter('userId', $this->userId);

        return $qb;
    }
}
