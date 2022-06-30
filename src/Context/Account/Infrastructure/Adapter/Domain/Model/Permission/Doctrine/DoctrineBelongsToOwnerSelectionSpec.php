<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine;

use App\Context\Account\Domain\Model\Permission\Permission;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineBelongsToOwnerSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine
 */
final class DoctrineBelongsToOwnerSelectionSpec implements DoctrinePermissionSelectionSpecInterface
{
    /**
     * @var string
     */
    private string $owner;

    /**
     * DoctrineBelongsToOwnerSelectionSpec constructor.
     * @param string $owner
     */
    public function __construct(string $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function addConditionToQb(QueryBuilder $qb): QueryBuilder
    {
        $qb->from(Permission::class, 'p')
            ->select('p')
            ->where('p.owner = :owner')
            ->setParameter('owner', $this->owner);

        return $qb;
    }
}
