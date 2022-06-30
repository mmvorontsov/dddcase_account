<?php

namespace App\Context\Account\Infrastructure\Validation\Constraint\Compound;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

/**
 * Class AbstractCompound
 * @package App\Context\Account\Infrastructure\Validation\Constraint\Compound
 */
abstract class AbstractCompound extends Compound
{
    public const NOT_NULL = 'NOT_NULL';

    /**
     * @param array $payload
     * @return array
     */
    protected function getNotNullConstraint(array $payload): array
    {
        if (!isset($payload[self::NOT_NULL])) {
            return [];
        }

        return [new Assert\NotNull(...$payload[self::NOT_NULL])];
    }
}
