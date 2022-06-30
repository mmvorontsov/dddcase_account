<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Users\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use App\Context\Account\Application\Common\Pagination\Pagination;
use App\Context\Account\Application\UseCase\Query\Users\UsersQueryServiceInterface;
use App\Context\Account\Application\UseCase\Query\Users\UsersRequest;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\AbstractQueryService;

use function array_map;

/**
 * Class DoctrineUsersQueryService
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\Users\Doctrine
 */
final class DoctrineUsersQueryService extends AbstractQueryService implements UsersQueryServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DoctrineUsersQueryService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UsersRequest $request
     * @return Pagination
     * @throws Exception
     */
    public function findUsers(UsersRequest $request): Pagination
    {
        $page = $request->getPage() ?? 1;
        $limit = $request->getLimit() ?? 50;

        $qb = $this->entityManager->createQueryBuilder();
        $qb = $qb->select('u', 'ur')
            ->from(User::class, 'u')
            ->leftJoin('u.userRoles', 'ur')
            ->setFirstResult($page * $limit - $limit)
            ->setMaxResults($limit);

        $this->andWhereByUserId($request, $qb);
        $this->andWhereByFirstname($request, $qb);

        $query = $qb->getQuery()->setHint(Query::HINT_READ_ONLY, true);
        $paginator = new Paginator($query);

        return new Pagination($page, $limit, $paginator->count(), $paginator->getIterator());
    }

    /**
     * @param UsersRequest $request
     * @param QueryBuilder $qb
     */
    private function andWhereByUserId(UsersRequest $request, QueryBuilder $qb): void
    {
        if (null === $request->getUserId()) {
            return;
        }

        $userId = array_map(
            fn(string $id) => UserId::createFrom($id),
            $this->getValueAsArray($request->getUserId()),
        );

        $qb->andWhere($qb->expr()->in('u.userId', ':userId'))
            ->setParameter('userId', $userId);
    }

    /**
     * @param UsersRequest $request
     * @param QueryBuilder $qb
     */
    private function andWhereByFirstname(UsersRequest $request, QueryBuilder $qb): void
    {
        if (null === $request->getFirstname()) {
            return;
        }

        $qb->andWhere($qb->expr()->like('u.firstname', ':firstname'))
            ->setParameter('firstname', "%{$request->getFirstname()}%");
    }
}
