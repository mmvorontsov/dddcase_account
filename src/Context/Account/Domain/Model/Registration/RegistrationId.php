<?php

namespace App\Context\Account\Domain\Model\Registration;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use Ramsey\Uuid\Uuid as BaseUuid;

/**
 * Class RegistrationId
 * @package App\Context\Account\Domain\Model\Registration
 */
class RegistrationId extends Uuid
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (false === BaseUuid::isValid($value)) {
            throw new DomainException('Registration ID must be in format UUID.');
        }

        return new static($value);
    }
}
