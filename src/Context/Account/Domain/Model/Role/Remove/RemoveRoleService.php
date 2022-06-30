<?php

namespace App\Context\Account\Domain\Model\Role\Remove;

use Exception;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleRepositoryInterface;

/**
 * Class RemoveRoleService
 * @package App\Context\Account\Domain\Model\Role\Remove
 */
final class RemoveRoleService implements RemoveRoleServiceInterface
{
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;

    /**
     * RemoveRoleService constructor.
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param Role $role
     * @throws Exception
     */
    public function execute(Role $role): void
    {
        $this->roleRepository->remove($role);

        DomainEventSubject::instance()->notify(
            new RoleRemoved($role)
        );
    }

    /**
     * @param Role[] $roles
     * @throws Exception
     */
    public function executeForAll(array $roles): void
    {
        foreach ($roles as $role) {
            $this->execute($role);
        }
    }
}
