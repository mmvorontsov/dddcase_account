<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use Ramsey\Uuid\Uuid as BaseUuid;

/**
 * Class ContactDataId
 * @package App\Context\Account\Domain\Model\ContactData
 */
class ContactDataId extends Uuid
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (false === BaseUuid::isValid($value)) {
            throw new DomainException('Contact data ID must be in format UUID.');
        }

        return new static($value);
    }
}
