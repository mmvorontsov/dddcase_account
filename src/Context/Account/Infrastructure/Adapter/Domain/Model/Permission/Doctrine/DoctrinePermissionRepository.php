<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine;

use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Permission\PermissionId;
use App\Context\Account\Domain\Model\Permission\PermissionRepositoryInterface;
use App\Context\Account\Domain\Model\Permission\PermissionSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrinePermissionRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Permission\Doctrine
 */
final class DoctrinePermissionRepository extends ServiceEntityRepository implements PermissionRepositoryInterface
{
    /**
     * DoctrinePermissionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    /**
     * @param Permission $permission
     * @throws ORMException
     */
    public function add(Permission $permission): void
    {
        $this->getEntityManager()->persist($permission);
    }

    /**
     * @param Permission $permission
     * @throws ORMException
     */
    public function remove(Permission $permission): void
    {
        $this->getEntityManager()->remove($permission);
    }

    /**
     * @param PermissionId $permissionId
     * @return Permission|null
     */
    public function findById(PermissionId $permissionId): ?Permission
    {
        return $this->find($permissionId);
    }

    /**
     * @param PermissionSelectionSpecInterface $spec
     * @return array
     */
    public function selectSatisfying(PermissionSelectionSpecInterface $spec): array
    {
        /** @var DoctrinePermissionSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getResult();
    }
}
