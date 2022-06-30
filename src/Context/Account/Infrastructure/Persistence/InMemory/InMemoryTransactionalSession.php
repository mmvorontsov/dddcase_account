<?php

namespace App\Context\Account\Infrastructure\Persistence\InMemory;

use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Persistence\UniqueConstraintViolationException;

/**
 * Class InMemoryTransactionalSession
 * @package App\Context\Account\Infrastructure\Persistence\InMemory
 */
class InMemoryTransactionalSession implements TransactionalSessionInterface
{
    /**
     * @param callable $operation
     * @return mixed
     * @throws UniqueConstraintViolationException
     */
    public function executeAtomically(callable $operation): mixed
    {
        return $operation();
    }
}
