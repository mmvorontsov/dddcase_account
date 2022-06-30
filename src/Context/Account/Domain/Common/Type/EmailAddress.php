<?php

namespace App\Context\Account\Domain\Common\Type;

use App\Context\Account\Domain\DomainException;

use function filter_var;

/**
 * Class EmailAddress
 * @package App\Context\Account\Domain\Common\Type
 */
class EmailAddress extends PrimaryContactData
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): self
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException('Email address must be in format EMAIL.');
        }

        return new static($value);
    }

    /**
     * @param EmailAddress $email
     * @return bool
     */
    public function isEqualTo(EmailAddress $email): bool
    {
        return $this->value === $email->getValue();
    }
}
