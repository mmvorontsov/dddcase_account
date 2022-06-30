<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\Inbox\Doctrine;

use App\Context\Account\Domain\Model\Inbox\Inbox;
use App\Context\Account\Domain\Model\Inbox\InboxId;
use App\Context\Account\Domain\Model\Inbox\InboxRepositoryInterface;
use App\Context\Account\Domain\Model\Inbox\InboxSelectionSpecInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineInboxRepository
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\Inbox\Doctrine
 */
final class DoctrineInboxRepository extends ServiceEntityRepository implements InboxRepositoryInterface
{
    /**
     * DoctrineInboxRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inbox::class);
    }

    /**
     * @param InboxId $inboxId
     * @return bool
     */
    public function containsId(InboxId $inboxId): bool
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i.inboxId')
            ->where($qb->expr()->eq('i.inboxId', ':inboxId'))
            ->setParameter('inboxId', $inboxId)
            ->setMaxResults(1);

        return !empty($qb->getQuery()->getScalarResult());
    }

    /**
     * @param Inbox $inbox
     * @throws ORMException
     */
    public function add(Inbox $inbox): void
    {
        $this->getEntityManager()->persist($inbox);
    }

    /**
     * @param Inbox $inbox
     */
    public function remove(Inbox $inbox): void
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param InboxSelectionSpecInterface $spec
     * @return Inbox[]
     */
    public function selectSatisfying(InboxSelectionSpecInterface $spec): array
    {
        /** @var DoctrineInboxSelectionSpecInterface $spec */

        return [];
    }
}
