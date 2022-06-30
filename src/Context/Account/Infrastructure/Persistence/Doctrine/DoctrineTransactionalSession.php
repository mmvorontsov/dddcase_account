<?php

namespace App\Context\Account\Infrastructure\Persistence\Doctrine;

use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Persistence\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException as DoctrineUniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

/**
 * Class DoctrineTransactionalSession
 * @package App\Context\Account\Infrastructure\Persistence\Doctrine
 */
class DoctrineTransactionalSession implements TransactionalSessionInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * DoctrineTransactionalSession constructor.
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param callable $operation
     * @return mixed
     */
    public function executeAtomically(callable $operation): mixed
    {
        try {
            return $this->entityManager->transactional($operation);
        } catch (DoctrineUniqueConstraintViolationException $e) {
            $this->managerRegistry->resetManager();
            throw new UniqueConstraintViolationException($e->getMessage(), $e);
        } catch (Throwable) {
            $this->managerRegistry->resetManager();
        }
    }
}
