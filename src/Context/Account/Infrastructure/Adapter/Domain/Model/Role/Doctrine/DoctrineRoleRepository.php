<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine;

use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\Role\RoleRepositoryInterface;
use App\Context\Account\Domain\Model\Role\RoleSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineRoleRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Role\Doctrine
 */
class DoctrineRoleRepository extends ServiceEntityRepository implements RoleRepositoryInterface
{
    /**
     * DoctrineRoleRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * @param Role $role
     * @throws ORMException
     */
    public function add(Role $role): void
    {
        $this->getEntityManager()->persist($role);
    }

    /**
     * @param Role $role
     * @throws ORMException
     */
    public function remove(Role $role): void
    {
        $this->getEntityManager()->remove($role);
    }

    /**
     * @param RoleId $roleId
     * @return Role|null
     */
    public function findById(RoleId $roleId): ?Role
    {
        return $this->find($roleId);
    }

    /**
     * @param RoleSelectionSpecInterface $spec
     * @return Role[]
     */
    public function selectSatisfying(RoleSelectionSpecInterface $spec): array
    {
        /** @var DoctrineRoleSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getResult();
    }
}
