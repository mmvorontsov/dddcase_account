<?php

namespace App\Context\Account\Infrastructure\Validation\Constraint\Compound;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LimitCompound
 * @package App\Context\Account\Infrastructure\Validation\Constraint\Compound
 */
final class LimitCompound extends AbstractCompound
{
    public const REQUIRED = 'required';

    /**
     * @param array $options
     * @return array
     */
    protected function getConstraints(array $options): array
    {
        $payload = $options['payload'] ?? [];

        return [
            ...$this->getNotNullConstraint($payload),
            new Assert\Type('int'),
            new Assert\Range(['min' => 1, 'max' => 100]),
        ];
    }
}
