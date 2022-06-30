<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine;

use App\Context\Account\Domain\Model\KeyMaker\KeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerId;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecInterface;
use App\Context\Account\Domain\Model\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineKeyMakerRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\KeyMaker\Doctrine
 */
final class DoctrineKeyMakerRepository extends ServiceEntityRepository implements KeyMakerRepositoryInterface
{
    /**
     * DoctrineKeyMakerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeyMaker::class);
    }

    /**
     * @param KeyMaker $keyMaker
     * @throws ORMException
     */
    public function add(KeyMaker $keyMaker): void
    {
        $this->getEntityManager()->persist($keyMaker);
    }

    /**
     * @param KeyMaker $keyMaker
     * @throws ORMException
     */
    public function remove(KeyMaker $keyMaker): void
    {
        $this->getEntityManager()->remove($keyMaker);
    }

    /**
     * @param KeyMakerId $keyMakerId
     * @return User|null
     */
    public function findById(KeyMakerId $keyMakerId): ?KeyMaker
    {
        return $this->find($keyMakerId);
    }

    /**
     * @param KeyMakerSelectionSpecInterface $spec
     * @return KeyMaker|null
     * @throws NonUniqueResultException
     */
    public function selectOneSatisfying(KeyMakerSelectionSpecInterface $spec): ?KeyMaker
    {
        /** @var DoctrineKeyMakerSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getOneOrNullResult();
    }
}
