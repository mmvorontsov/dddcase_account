<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\Permission\PermissionDto;
use App\Context\Account\Domain\Model\Permission\Permission;

use function array_map;

/**
 * Class UserPermissionsResponse
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 */
final class UserPermissionsResponse
{
    /**
     * @var PermissionDto[]
     */
    private array $items;

    /**
     * UserPermissionsResponse constructor.
     * @param Permission[] $permissions
     */
    public function __construct(array $permissions)
    {
        $this->items = array_map(
            static function (Permission $permission) {
                return PermissionDto::createFromPermission($permission);
            },
            $permissions
        );
    }

    /**
     * @return PermissionDto[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
