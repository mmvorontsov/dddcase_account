<?php

namespace App\Context\Account\Domain\Model\Role\Remove;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\Role\Role;

/**
 * Class RoleRemoved
 * @package App\Context\Account\Domain\Model\Role\Remove
 */
final class RoleRemoved extends DomainEvent
{
    /**
     * @var Role
     */
    private Role $role;

    /**
     * RoleRemoved constructor.
     * @param Role $role
     * @throws Exception
     */
    public function __construct(Role $role)
    {
        parent::__construct();
        $this->role = $role;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }
}
