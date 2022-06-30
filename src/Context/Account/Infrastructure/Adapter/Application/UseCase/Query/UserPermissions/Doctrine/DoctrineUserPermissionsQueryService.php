<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserPermissions\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use App\Context\Account\Application\UseCase\Query\UserPermissions\UserPermissionsQueryServiceInterface;
use App\Context\Account\Application\UseCase\Query\UserPermissions\UserPermissionsRequest;
use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Role\RolePermission\RolePermission;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class DoctrineUserPermissionsQueryService
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserPermissions\Doctrine
 */
final class DoctrineUserPermissionsQueryService implements UserPermissionsQueryServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DoctrineUserPermissionsQueryService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserPermissionsRequest $request
     * @return Permission[]
     */
    public function findPermissions(UserPermissionsRequest $request): array
    {
        $userId = UserId::createFrom($request->getUserId());

        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->select('p')
            ->from(User::class, 'u')
            ->innerJoin('u.userRoles', 'ur')
            ->innerJoin(
                RolePermission::class,
                'rp',
                Expr\Join::WITH,
                'rp.role = ur.roleId',
            )
            ->innerJoin(
                Permission::class,
                'p',
                Expr\Join::WITH,
                'p.permissionId = rp.permissionId',
            )
            ->where('u.userId = :userId')
            ->setParameter('userId', $userId)
            ->groupBy('p.permissionId')
            ->getQuery()
            ->setHint(Query::HINT_READ_ONLY, true);

        return $query->getResult();
    }
}
