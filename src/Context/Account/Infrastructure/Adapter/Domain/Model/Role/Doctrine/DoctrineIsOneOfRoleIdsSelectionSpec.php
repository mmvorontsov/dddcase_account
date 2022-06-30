<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine;

use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineIsOneOfRoleIdsSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine
 */
final class DoctrineIsOneOfRoleIdsSelectionSpec implements DoctrineRoleSelectionSpecInterface
{
    /**
     * @var RoleId[]
     */
    private array $roleIds;

    /**
     * DoctrineIsOneOfRoleIdsSelectionSpec constructor.
     * @param RoleId[] $roleIds
     */
    public function __construct(array $roleIds)
    {
        $this->roleIds = $roleIds;
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
            ->where($qb->expr()->in('r.roleId', ':roleIds'))
            ->setParameter('roleIds', $this->roleIds);

        return $qb;
    }
}
