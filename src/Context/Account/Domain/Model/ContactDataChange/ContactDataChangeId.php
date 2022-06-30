<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use Ramsey\Uuid\Uuid as BaseUuid;

/**
 * Class ContactDataChangeId
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
class ContactDataChangeId extends Uuid
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (false === BaseUuid::isValid($value)) {
            throw new DomainException('Contact data change ID must be in format UUID.');
        }

        return new static($value);
    }
}
