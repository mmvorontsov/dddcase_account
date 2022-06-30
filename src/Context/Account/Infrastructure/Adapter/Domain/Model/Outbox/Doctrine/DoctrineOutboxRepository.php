<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine;

use App\Context\Account\Domain\Model\Outbox\Outbox;
use App\Context\Account\Domain\Model\Outbox\OutboxRepositoryInterface;
use App\Context\Account\Domain\Model\Outbox\OutboxSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineOutboxRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Outbox\Doctrine
 */
final class DoctrineOutboxRepository extends ServiceEntityRepository implements OutboxRepositoryInterface
{
    /**
     * DoctrineOutboxRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Outbox::class);
    }

    /**
     * @param Outbox $outbox
     * @throws ORMException
     */
    public function add(Outbox $outbox): void
    {
        $this->getEntityManager()->persist($outbox);
    }

    /**
     * @param Outbox $outbox
     * @throws ORMException
     */
    public function remove(Outbox $outbox): void
    {
        $this->getEntityManager()->remove($outbox);
    }

    /**
     * @param OutboxSelectionSpecInterface $spec
     * @return Outbox[]
     */
    public function selectSatisfying(OutboxSelectionSpecInterface $spec): array
    {
        /** @var DoctrineOutboxSelectionSpecInterface $spec */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $spec->addConditionToQb($qb)->getQuery();

        return $query->getResult();
    }
}
