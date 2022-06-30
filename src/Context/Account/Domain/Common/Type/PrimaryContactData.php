<?php

namespace App\Context\Account\Domain\Common\Type;

/**
 * Class PrimaryContactData
 * @package App\Context\Account\Domain\Common\Type
 */
abstract class PrimaryContactData
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * PrimaryContactData constructor.
     * @param string $value
     */
    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return EmailAddress|null
     */
    public function getEmailAddressOrNull(): ?EmailAddress
    {
        return $this instanceof EmailAddress ? $this : null;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhoneNumberOrNull(): ?PhoneNumber
    {
        return $this instanceof PhoneNumber ? $this : null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
