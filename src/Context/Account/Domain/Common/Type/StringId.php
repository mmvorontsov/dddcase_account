<?php

namespace App\Context\Account\Domain\Common\Type;

/**
 * Class StringId
 * @package App\Context\Account\Domain\Common\Type
 */
abstract class StringId
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     */
    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return static
     */
    abstract public static function createFrom(string $value): static;

    /**
     * @param StringId $stringId
     * @return bool
     */
    public function isEqualTo(StringId $stringId): bool
    {
        return $this->value === $stringId->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
