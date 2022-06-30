<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Model\Permission;

use App\Context\Account\Domain\Model\Permission\Permission;
use OpenApi\Annotations as OA;

/**
 * Class PermissionDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Model\Permission
 */
final class PermissionDto
{
    /**
     * @var string
     *
     * @OA\Property(format="uuid")
     */
    private string $permissionId;

    /**
     * @var string
     *
     * @OA\Property(description="Allowed for: ROLE_PROTECTED__USER__SUPER, ROLE__USER__DDDCASE_ACCOUNT__ADMIN")
     */
    private string $owner;

    /**
     * @var string
     */
    private string $description;

    /**
     * PermissionDto constructor.
     * @param string $permissionId
     * @param string $owner
     * @param string $description
     */
    public function __construct(string $permissionId, string $owner, string $description)
    {
        $this->permissionId = $permissionId;
        $this->owner = $owner;
        $this->description = $description;
    }

    /**
     * @param Permission $permission
     * @return PermissionDto
     */
    public static function createFromPermission(Permission $permission): PermissionDto
    {
        return new self(
            $permission->getPermissionId()->getValue(),
            $permission->getOwner(),
            $permission->getDescription(),
        );
    }

    /**
     * @return string
     */
    public function getPermissionId(): string
    {
        return $this->permissionId;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
