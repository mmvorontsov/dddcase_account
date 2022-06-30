<?php

namespace App\Context\Account\Domain\Common\Type;

/**
 * Class PhoneNumber
 * @package App\Context\Account\Domain\Common\Type
 */
class PhoneNumber extends PrimaryContactData
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): self
    {
        return new static($value);
    }

    /**
     * @param PhoneNumber $phone
     * @return bool
     */
    public function isEqualTo(PhoneNumber $phone): bool
    {
        return $this->value === $phone->getValue();
    }
}
