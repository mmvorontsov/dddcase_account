<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Roles\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use App\Context\Account\Application\Common\Pagination\Pagination;
use App\Context\Account\Application\UseCase\Query\Roles\RolesQueryServiceInterface;
use App\Context\Account\Application\UseCase\Query\Roles\RolesRequest;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\AbstractQueryService;

use function array_map;

/**
 * Class DoctrineRolesQueryService
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Roles\Doctrine
 */
final class DoctrineRolesQueryService extends AbstractQueryService implements RolesQueryServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DoctrineRolesQueryService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param RolesRequest $request
     * @return Pagination
     * @throws Exception
     */
    public function findRoles(RolesRequest $request): Pagination
    {
        $page = $request->getPage() ?? 1;
        $limit = $request->getLimit() ?? 50;

        $qb = $this->entityManager->createQueryBuilder();
        $qb = $qb->select('r', 'rp')
            ->from(Role::class, 'r')
            ->leftJoin('r.rolePermissions', "rp")
            ->setFirstResult($page * $limit - $limit)
            ->setMaxResults($limit);

        $this->andWhereByRoleId($request, $qb);
        $this->andWhereByOwner($request, $qb);

        $query = $qb->getQuery()->setHint(Query::HINT_READ_ONLY, true);
        $paginator = new Paginator($query);

        return new Pagination($page, $limit, $paginator->count(), $paginator->getIterator());
    }

    /**
     * @param RolesRequest $request
     * @param QueryBuilder $qb
     */
    private function andWhereByRoleId(RolesRequest $request, QueryBuilder $qb): void
    {
        if (null === $request->getRoleId()) {
            return;
        }

        $roleId = array_map(
            fn(string $id) => RoleId::createFrom($id),
            $this->getValueAsArray($request->getRoleId()),
        );

        $qb->andWhere($qb->expr()->in('r.roleId', ':roleId'))
            ->setParameter('roleId', $roleId);
    }

    /**
     * @param RolesRequest $request
     * @param QueryBuilder $qb
     */
    private function andWhereByOwner(RolesRequest $request, QueryBuilder $qb): void
    {
        if (null === $request->getOwner()) {
            return;
        }

        $qb->andWhere($qb->expr()->like('r.owner', ':owner'))
            ->setParameter('owner', "%{$request->getOwner()}%");
    }
}
