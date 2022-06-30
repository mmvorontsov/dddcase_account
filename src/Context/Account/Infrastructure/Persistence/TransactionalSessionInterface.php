<?php

namespace App\Context\Account\Infrastructure\Persistence;

/**
 * Interface TransactionalSessionInterface
 * @package App\Context\Account\Infrastructure\Persistence
 */
interface TransactionalSessionInterface
{
    /**
     * @param callable $operation
     * @return mixed
     * @throws UniqueConstraintViolationException
     */
    public function executeAtomically(callable $operation): mixed;
}
