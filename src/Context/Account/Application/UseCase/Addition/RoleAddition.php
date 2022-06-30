<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\Role\RoleRepositoryInterface;

/**
 * Class RoleAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class RoleAddition implements RoleAdditionInterface
{
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;

    /**
     * RoleAddition constructor.
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param RoleId $id
     * @return Role|null
     */
    public function findById(RoleId $id): ?Role
    {
        return $this->roleRepository->findById($id);
    }

    /**
     * @param RoleId $id
     * @param string|null $msg
     * @return Role
     */
    public function findByIdOrNotFound(RoleId $id, string $msg = null): Role
    {
        $role = $this->findById($id);
        if (null === $role) {
            throw new NotFoundException($msg ?? 'Role not found.');
        }

        return $role;
    }
}
