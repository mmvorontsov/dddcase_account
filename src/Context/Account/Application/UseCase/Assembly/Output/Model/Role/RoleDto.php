<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\Role;

use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RolePermission\RolePermission;
use OpenApi\Annotations as OA;

/**
 * Class RoleDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\Role
 */
final class RoleDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $roleId;

    /**
     * @var string
     */
    private string $owner;

    /**
     * @var string[]
     */
    private array $permissionIds;

    /**
     * RoleDto constructor.
     * @param string $roleId
     * @param string $owner
     * @param string[] $permissionIds
     */
    public function __construct(string $roleId, string $owner, array $permissionIds)
    {
        $this->roleId = $roleId;
        $this->owner = $owner;
        $this->permissionIds = $permissionIds;
    }

    /**
     * @param Role $role
     * @return static
     */
    public static function createFromRole(Role $role): self
    {
        return new self(
            $role->getRoleId()->getValue(),
            $role->getOwner(),
            $role->getRolePermissions()
                ->map(
                    static function (RolePermission $rolePermission) {
                        return $rolePermission->getPermissionId()->getValue();
                    },
                )
                ->getValues(),
        );
    }

    /**
     * @return string
     */
    public function getRoleId(): string
    {
        return $this->roleId;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return string[]
     */
    public function getPermissionIds(): array
    {
        return $this->permissionIds;
    }
}
