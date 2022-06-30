<?php

namespace App\Context\Account\Domain\Model\Role\RolePermission;

use App\Context\Account\Domain\Common\Type\Uuid;
use Exception;
use App\Context\Account\Domain\Model\Permission\PermissionId;
use App\Context\Account\Domain\Model\Role\Role;

/**
 * Class RolePermission
 * @package App\Context\Account\Domain\Model\Role\RolePermission
 */
final class RolePermission
{
    /**
     * @var Role
     */
    private Role $role;

    /**
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * @var PermissionId
     */
    private PermissionId $permissionId;

    /**
     * RolePermission constructor.
     * @param Role $role
     * @param Uuid $uuid
     * @param PermissionId $permissionId
     */
    public function __construct(Role $role, Uuid $uuid, PermissionId $permissionId)
    {
        $this->role = $role;
        $this->uuid = $uuid;
        $this->permissionId = $permissionId;
    }

    /**
     * @param Role $role
     * @param PermissionId $permissionId
     * @return RolePermission
     * @throws Exception
     */
    public static function create(Role $role, PermissionId $permissionId): RolePermission
    {
        return new self($role, Uuid::create(), $permissionId);
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return PermissionId
     */
    public function getPermissionId(): PermissionId
    {
        return $this->permissionId;
    }
}
