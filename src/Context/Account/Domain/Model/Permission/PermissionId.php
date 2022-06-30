<?php

namespace App\Context\Account\Domain\Model\Permission;

use App\Context\Account\Domain\Common\Type\StringId;
use App\Context\Account\Domain\DomainException;

use function str_starts_with;

/**
 * Class PermissionId
 * @package App\Context\Account\Domain\Model\Permission
 */
class PermissionId extends StringId
{
    /**
     * @param string $value
     * @return static
     */
    public static function createFrom(string $value): static
    {
        if (!str_starts_with($value, 'PERMISSION_')) {
            throw new DomainException('Permission ID must be prefixed with PERMISSION_.');
        }

        return new static($value);
    }
}
