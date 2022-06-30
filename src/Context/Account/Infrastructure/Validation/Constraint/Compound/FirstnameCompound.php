<?php

namespace App\Context\Account\Infrastructure\Validation\Constraint\Compound;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class FirstnameCompound
 * @package App\Context\Account\Infrastructure\Validation\Constraint\Compound
 */
final class FirstnameCompound extends AbstractCompound
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
            new Assert\Length(['min' => 1, 'max' => 50]),
        ];
    }
}
