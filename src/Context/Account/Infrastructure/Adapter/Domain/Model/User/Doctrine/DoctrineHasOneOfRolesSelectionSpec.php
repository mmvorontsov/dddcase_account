<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine;

use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\User;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DoctrineHasOneOfRolesSelectionSpec
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine
 */
final class DoctrineHasOneOfRolesSelectionSpec implements DoctrineUserSelectionSpecInterface
{
    /**
     * @var RoleId[]
     */
    private array $roleIds;

    /**
     * DoctrineHasOneOfRolesSelectionSpec constructor.
     * @param array $roleIds
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
        $qb->from(User::class, 'u')
            ->select('u', 'ur')
            ->leftJoin('u.userRoles', 'ur')
            ->where($qb->expr()->in('ur.roleId', ':roleIds'))
            ->setParameter('roleIds', $this->roleIds);

        return $qb;
    }
}
