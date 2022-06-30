<?php

namespace App\Context\Account\Domain\Model\Role;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\Permission\PermissionId;
use App\Context\Account\Domain\Model\Role\RolePermission\RolePermission;

/**
 * Class Role
 * @package App\Context\Account\Domain\Model\Role
 */
class Role implements AggregateRootInterface
{
    /**
     * @var RoleId
     */
    private RoleId $roleId;

    /**
     * @var string
     */
    private string $owner;

    /**
     * @var Collection
     */
    private Collection $rolePermissions;

    /**
     * Role constructor.
     * @param RoleId $roleId
     * @param string $owner
     * @param ArrayCollection $rolePermissions
     */
    public function __construct(RoleId $roleId, string $owner, ArrayCollection $rolePermissions)
    {
        $this->roleId = $roleId;
        $this->owner = $owner;
        $this->rolePermissions = $rolePermissions;
    }

    /**
     * @param string $roleId
     * @param string $owner
     * @return Role
     */
    public static function create(string $roleId, string $owner): Role
    {
        return new self(
            RoleId::createFrom($roleId),
            $owner,
            new ArrayCollection(),
        );
    }

    /**
     * @param PermissionId $permissionId
     * @throws Exception
     */
    public function addRolePermission(PermissionId $permissionId): void
    {
        if (!$this->rolePermissions->containsKey($permissionId->getValue())) {
            $rolePermission = RolePermission::create($this, $permissionId);
            $this->rolePermissions->set($permissionId->getValue(), $rolePermission);
        }
    }

    /**
     * @param PermissionId $permissionId
     */
    public function removeRolePermission(PermissionId $permissionId): void
    {
        $this->rolePermissions->remove($permissionId->getValue());
    }

    /**
     * @return RoleId
     */
    public function getRoleId(): RoleId
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
     * @return Collection
     */
    public function getRolePermissions(): Collection
    {
        return $this->rolePermissions;
    }
}
