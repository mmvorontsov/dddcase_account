<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;

/**
 * Interface RoleAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface RoleAdditionInterface
{
    /**
     * @param RoleId $id
     * @return Role|null
     */
    public function findById(RoleId $id): ?Role;

    /**
     * @param RoleId $id
     * @param string|null $msg
     * @return Role
     */
    public function findByIdOrNotFound(RoleId $id, string $msg = null): Role;
}
