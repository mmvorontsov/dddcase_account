<?php

namespace App\Context\Account\Domain\Model\Role\RolePermission;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;

/**
 * Class RolePermissionAdded
 * @package App\Context\Account\Domain\Model\Role\RolePermission
 */
final class RolePermissionAdded extends DomainEvent
{
    /**
     * @var RolePermission
     */
    private RolePermission $rolePermission;

    /**
     * RolePermissionAdded constructor.
     * @param RolePermission $rolePermission
     * @throws Exception
     */
    public function __construct(RolePermission $rolePermission)
    {
        parent::__construct();
        $this->rolePermission = $rolePermission;
    }

    /**
     * @return RolePermission
     */
    public function rolePermission(): RolePermission
    {
        return $this->rolePermission;
    }
}
