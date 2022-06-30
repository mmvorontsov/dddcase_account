<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine;

use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialId;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\Credential\CredentialSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineCredentialRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Credential\Doctrine
 */
final class DoctrineCredentialRepository extends ServiceEntityRepository implements CredentialRepositoryInterface
{
    /**
     * DoctrineCredentialRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credential::class);
    }

    /**
     * @param Credential $credential
     * @throws ORMException
     */
    public function add(Credential $credential): void
    {
        $this->getEntityManager()->persist($credential);
    }

    /**
     * @param CredentialId $credentialId
     * @return Credential|null
     */
    public function findById(CredentialId $credentialId): ?Credential
    {
        return $this->find($credentialId);
    }

    /**
     * @param CredentialSelectionSpecInterface $spec
     * @return Credential|null
     * @throws NonUniqueResultException
     */
    public function selectOneSatisfying(CredentialSelectionSpecInterface $spec): ?Credential
    {
        /** @var DoctrineCredentialSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getOneOrNullResult();
    }
}
