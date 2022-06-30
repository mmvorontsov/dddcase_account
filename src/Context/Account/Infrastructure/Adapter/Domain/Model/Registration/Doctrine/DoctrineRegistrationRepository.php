<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine;

use App\Context\Account\Domain\Model\Outbox\Outbox;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Registration\RegistrationRepositoryInterface;
use App\Context\Account\Domain\Model\Registration\RegistrationSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineRegistrationRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Registration\Doctrine
 */
final class DoctrineRegistrationRepository extends ServiceEntityRepository implements RegistrationRepositoryInterface
{
    /**
     * DoctrineRegistrationRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registration::class);
    }

    /**
     * @param RegistrationId $registrationId
     * @return bool
     */
    public function containsId(RegistrationId $registrationId): bool
    {
        $qb = $this->createQueryBuilder('r');

        $qb->select('r.registrationId')
            ->where($qb->expr()->eq('r.registrationId', ':registrationId'))
            ->setParameter('registrationId', $registrationId)
            ->setMaxResults(1);

        return !empty($qb->getQuery()->getScalarResult());
    }

    /**
     * @param Registration $registration
     * @throws ORMException
     */
    public function add(Registration $registration): void
    {
        $this->getEntityManager()->persist($registration);
    }

    /**
     * @param Registration $registration
     * @throws ORMException
     */
    public function remove(Registration $registration): void
    {
        $this->getEntityManager()->remove($registration);
    }

    /**
     * @param RegistrationId $registrationId
     * @return Registration|null
     */
    public function findById(RegistrationId $registrationId): ?Registration
    {
        return $this->find($registrationId);
    }

    /**
     * @param RegistrationSelectionSpecInterface $spec
     * @return Outbox[]
     */
    public function selectSatisfying(RegistrationSelectionSpecInterface $spec): array
    {
        /** @var DoctrineRegistrationSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getResult();
    }
}
