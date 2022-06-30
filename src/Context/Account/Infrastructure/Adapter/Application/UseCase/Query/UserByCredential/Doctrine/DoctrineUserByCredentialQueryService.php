<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserByCredential\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use App\Context\Account\Application\UseCase\Query\UserByCredential\UserByCredentialQueryServiceInterface;
use App\Context\Account\Application\UseCase\Query\UserByCredential\UserByCredentialRequest;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class DoctrineUserByCredentialQueryService
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserByCredential\Doctrine
 */
final class DoctrineUserByCredentialQueryService implements UserByCredentialQueryServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * DoctrineUserByCredentialQueryService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserByCredentialRequest $request
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findUser(UserByCredentialRequest $request): ?User
    {
        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->select('u')
            ->from(User::class, 'u')
            ->innerJoin('u.userRoles', 'ur')
            ->innerJoin(
                Credential::class,
                'c',
                Expr\Join::WITH,
                'c.userId = u.userId',
            )
            ->innerJoin(
                ContactData::class,
                'cd',
                Expr\Join::WITH,
                'cd.userId = u.userId',
            )
            ->where('c.username = :login')
            ->orWhere('cd.email = :login')
            ->orWhere('cd.phone = :login')
            ->setParameter('login', $request->getLogin())
            ->setMaxResults(1)
            ->getQuery()
            ->setHint(Query::HINT_READ_ONLY, true);

        return $query->getOneOrNullResult();
    }
}
