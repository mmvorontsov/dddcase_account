<?php

namespace App\Context\Account\Domain\Model\User;

use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use Ramsey\Uuid\Uuid as BaseUuid;

/**
 * Class UserId
 * @package App\Context\Account\Domain\Model\User
 */
class UserId extends Uuid
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (false === BaseUuid::isValid($value)) {
            throw new DomainException('User ID must be in format UUID.');
        }

        return new static($value);
    }
}
