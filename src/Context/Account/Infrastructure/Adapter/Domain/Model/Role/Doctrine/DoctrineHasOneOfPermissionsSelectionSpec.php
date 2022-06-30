<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine;

use App\Context\Account\Domain\Model\Permission\PermissionId;
use App\Context\Account\Domain\Model\Role\Role;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineHasOneOfPermissionsSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine
 */
final class DoctrineHasOneOfPermissionsSelectionSpec implements DoctrineRoleSelectionSpecInterface
{
    /**
     * @var PermissionId[]
     */
    private array $permissionIds;

    /**
     * DoctrineHasOneOfPermissionsSelectionSpec constructor.
     * @param array $permissionIds
     */
    public function __construct(array $permissionIds)
    {
        $this->permissionIds = $permissionIds;
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
            ->where($qb->expr()->in('rp.permissionId', ':permissionIds'))
            ->setParameter('permissionIds', $this->permissionIds);

        return $qb;
    }
}
