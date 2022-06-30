<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine;

use App\Context\Account\Domain\Model\Role\Role;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineBelongsToOwnerSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine
 */
final class DoctrineBelongsToOwnerSelectionSpec implements DoctrineRoleSelectionSpecInterface
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
        $qb->from(Role::class, 'r')
            ->select('r', 'rp')
            ->leftJoin('r.rolePermissions', 'rp')
            ->where('r.owner = :owner')
            ->setParameter('owner', $this->owner);

        return $qb;
    }
}
