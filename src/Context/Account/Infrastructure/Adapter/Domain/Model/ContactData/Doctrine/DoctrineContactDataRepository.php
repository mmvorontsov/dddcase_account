<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine;

use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataId;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineContactDataRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine
 */
final class DoctrineContactDataRepository extends ServiceEntityRepository implements ContactDataRepositoryInterface
{
    /**
     * DoctrineContactDataRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactData::class);
    }

    /**
     * @param ContactData $contactData
     * @throws ORMException
     */
    public function add(ContactData $contactData): void
    {
        $this->getEntityManager()->persist($contactData);
    }

    /**
     * @param ContactDataId $contactDataId
     * @return ContactData|null
     */
    public function findById(ContactDataId $contactDataId): ?ContactData
    {
        return $this->find($contactDataId);
    }

    /**
     * @param ContactDataSelectionSpecInterface $spec
     * @return ContactData|null
     * @throws NonUniqueResultException
     */
    public function selectOneSatisfying(ContactDataSelectionSpecInterface $spec): ?ContactData
    {
        /** @var DoctrineContactDataSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getOneOrNullResult();
    }
}
