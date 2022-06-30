<?php

namespace App\Context\Account\Application\Security\AccessControl\Role;

use MyCLabs\Enum\Enum;

/**
 * Roles of users of this service.
 * These are roles that are used by this context when checking access.
 *
 * Class ContextUserRoleEnum
 * @package App\Context\Account\Application\Security\AccessControl\Role\Incoming
 */
final class ContextUserRoleEnum extends Enum
{
    public const ROLE__USER__DDDCASE_ACCOUNT__ADMIN = 'ROLE__USER__DDDCASE_ACCOUNT__ADMIN';
}
