<?php

namespace App\Context\Account\Infrastructure\Validation\Constraint\Compound;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PhoneCompound
 * @package App\Context\Account\Infrastructure\Validation\Constraint\Compound
 */
final class PhoneCompound extends AbstractCompound
{
    /**
     * @param array $options
     * @return array
     */
    protected function getConstraints(array $options): array
    {
        $payload = $options['payload'] ?? [];

        return [
            ...$this->getNotNullConstraint($payload),
            new Assert\Type('string'),
        ];
    }
}
