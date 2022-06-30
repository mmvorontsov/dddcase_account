<?php

namespace App\Context\Account\Domain\Model\Permission\Remove;

use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Permission\PermissionRepositoryInterface;
use Exception;

/**
 * Class RemovePermissionService
 * @package App\Context\Account\Domain\Model\Permission\Remove
 */
final class RemovePermissionService implements RemovePermissionServiceInterface
{
    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * RemovePermissionService constructor.
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param Permission $permission
     * @throws Exception
     */
    public function execute(Permission $permission): void
    {
        $this->permissionRepository->remove($permission);
    }

    /**
     * @param Permission[] $permissions
     * @throws Exception
     */
    public function executeForAll(array $permissions): void
    {
        foreach ($permissions as $permission) {
            $this->execute($permission);
        }
    }
}
