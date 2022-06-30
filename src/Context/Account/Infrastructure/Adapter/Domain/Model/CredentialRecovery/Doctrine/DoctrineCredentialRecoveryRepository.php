<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\CredentialRecovery\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryRepositoryInterface;

/**
 * Class DoctrineCredentialRecoveryRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\CredentialRecovery\Doctrine
 */
final class DoctrineCredentialRecoveryRepository extends ServiceEntityRepository implements
    CredentialRecoveryRepositoryInterface
{
    /**
     * DoctrineCredentialRecoveryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CredentialRecovery::class);
    }

    /**
     * @param CredentialRecovery $credentialRecovery
     * @throws ORMException
     */
    public function add(CredentialRecovery $credentialRecovery): void
    {
        $this->getEntityManager()->persist($credentialRecovery);
    }

    /**
     * @param CredentialRecovery $credentialRecovery
     * @throws ORMException
     */
    public function remove(CredentialRecovery $credentialRecovery): void
    {
        $this->getEntityManager()->remove($credentialRecovery);
    }

    /**
     * @param CredentialRecoveryId $credentialRecoveryId
     * @return CredentialRecovery|null
     */
    public function findById(CredentialRecoveryId $credentialRecoveryId): ?CredentialRecovery
    {
        return $this->find($credentialRecoveryId);
    }
}
