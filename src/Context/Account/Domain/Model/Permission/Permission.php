<?php

namespace App\Context\Account\Domain\Model\Permission;

use App\Context\Account\Domain\Model\AggregateRootInterface;

/**
 * Class Permission
 * @package App\Context\Account\Domain\Model\Permission
 */
class Permission implements AggregateRootInterface
{
    /**
     * @var PermissionId
     */
    private PermissionId $permissionId;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var string
     */
    private string $owner;

    /**
     * Permission constructor.
     * @param PermissionId $permissionId
     * @param string $description
     * @param string $owner
     */
    public function __construct(PermissionId $permissionId, string $description, string $owner)
    {
        $this->permissionId = $permissionId;
        $this->description = $description;
        $this->owner = $owner;
    }

    /**
     * @param string $permissionId
     * @param string $description
     * @param string $owner
     * @return Permission
     */
    public static function create(string $permissionId, string $description, string $owner): Permission
    {
        return new self(
            PermissionId::createFrom($permissionId),
            $description,
            $owner,
        );
    }

    /**
     * @param string $description
     */
    public function updateDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return PermissionId
     */
    public function getPermissionId(): PermissionId
    {
        return $this->permissionId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }
}
