<?php

namespace App\Context\Account\Domain\Model\Outbox;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use Ramsey\Uuid\Uuid as BaseUuid;

/**
 * Class OutboxId
 * @package App\Context\Account\Domain\Model\Outbox
 */
class OutboxId extends Uuid
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (false === BaseUuid::isValid($value)) {
            throw new DomainException('Outbox ID must be in format UUID.');
        }

        return new static($value);
    }
}
