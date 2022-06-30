<?php

namespace App\Context\Account\Application\Security\AccessControl\Role;

use MyCLabs\Enum\Enum;

/**
 * Roles of other services as users of this service.
 * This is a list of roles that are used by this context when checking access.
 *
 * Class ServiceRoleEnum
 * @package App\Context\Account\Application\Security\AccessControl\Role\Service
 */
final class ServiceRoleEnum extends Enum
{
    public const ROLE__SERVICE__BASE = 'ROLE__SERVICE__BASE';
}
