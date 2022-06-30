<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine;

use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Domain\Model\User\UserRepositoryInterface;
use App\Context\Account\Domain\Model\User\UserSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineUserRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\User\Doctrine
 */
final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    /**
     * DoctrineUserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param UserId $userId
     * @return bool
     */
    public function containsId(UserId $userId): bool
    {
        $qb = $this->createQueryBuilder('u');

        $qb->select('u.userId')
            ->where($qb->expr()->eq('u.userId', ':userId'))
            ->setParameter('userId', $userId)
            ->setMaxResults(1);

        return !empty($qb->getQuery()->getScalarResult());
    }

    /**
     * @param User $user
     * @throws ORMException
     */
    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    /**
     * @param UserId $userId
     * @return User|null
     */
    public function findById(UserId $userId): ?User
    {
        return $this->find($userId);
    }

    /**
     * @param UserSelectionSpecInterface $spec
     * @return array
     */
    public function selectSatisfying(UserSelectionSpecInterface $spec): array
    {
        /** @var DoctrineUserSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getResult();
    }
}
