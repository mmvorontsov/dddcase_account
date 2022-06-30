<?php

namespace App\Context\Account\Domain\Common\Type;

use Exception;
use App\Context\Account\Domain\DomainException;
use Ramsey\Uuid\Uuid as BaseUuid;

/**
 * Class Uuid
 * @package App\Context\Account\Domain\Common\Type
 */
class Uuid extends StringId
{
    /**
     * @return static
     * @throws Exception
     */
    public static function create(): self
    {
        return new static(BaseUuid::uuid4()->toString());
    }

    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (false === BaseUuid::isValid($value)) {
            throw new DomainException('ID must be in format GUID.');
        }

        return new static($value);
    }
}
