<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeRepositoryInterface;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineContactDataChangeRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactDataChange\Doctrine
 */
final class DoctrineContactDataChangeRepository extends ServiceEntityRepository implements
    ContactDataChangeRepositoryInterface
{
    /**
     * DoctrineContactDataChangeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactDataChange::class);
    }

    /**
     * @param ContactDataChange $contactDataChange
     * @throws ORMException
     */
    public function add(ContactDataChange $contactDataChange): void
    {
        $this->getEntityManager()->persist($contactDataChange);
    }

    /**
     * @param ContactDataChange $contactDataChange
     * @throws ORMException
     */
    public function remove(ContactDataChange $contactDataChange): void
    {
        $this->getEntityManager()->remove($contactDataChange);
    }

    /**
     * @param ContactDataChangeId $contactDataChangeId
     * @return ContactDataChange|null
     */
    public function findById(ContactDataChangeId $contactDataChangeId): ?ContactDataChange
    {
        return $this->find($contactDataChangeId);
    }

    /**
     * @param ContactDataChangeSelectionSpecInterface $spec
     * @return ContactDataChange|null
     * @throws NonUniqueResultException
     */
    public function selectOneSatisfying(ContactDataChangeSelectionSpecInterface $spec): ?ContactDataChange
    {
        /** @var DoctrineContactDataChangeSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getOneOrNullResult();
    }
}
