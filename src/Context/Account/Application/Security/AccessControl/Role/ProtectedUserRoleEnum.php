<?php

namespace App\Context\Account\Application\Security\AccessControl\Role;

use MyCLabs\Enum\Enum;

/**
 * These are the common roles of the core functionality.
 * These are the roles that cannot be managed of OTHER services.
 *
 * Class ProtectedUserRoleEnum
 * @package App\Context\Account\Application\Security\AccessControl\Role
 */
final class ProtectedUserRoleEnum extends Enum
{
    public const ROLE_PROTECTED__USER__BASE = 'ROLE_PROTECTED__USER__BASE';
    public const ROLE_PROTECTED__USER__ADMIN = 'ROLE_PROTECTED__USER__ADMIN';
    public const ROLE_PROTECTED__USER__SUPER = 'ROLE_PROTECTED__USER__SUPER';
}
