<?php

namespace App\Context\Account\Domain\Model\Role;

use App\Context\Account\Domain\Common\Type\StringId;
use App\Context\Account\Domain\DomainException;

use function str_starts_with;

/**
 * Class RoleId
 * @package App\Context\Account\Domain\Model\Role
 */
class RoleId extends StringId
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (!str_starts_with($value, 'ROLE_')) {
            throw new DomainException('Role ID must be prefixed with ROLE_.');
        }

        return new static($value);
    }
}
