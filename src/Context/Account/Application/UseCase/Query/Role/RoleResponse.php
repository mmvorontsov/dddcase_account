<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\Role\RoleDto;
use App\Context\Account\Domain\Model\Role\Role;

/**
 * Class RoleResponse
 * @package App\Context\Account\Application\UseCase\Query\Role
 */
final class RoleResponse
{
    /**
     * @var RoleDto
     */
    private RoleDto $item;

    /**
     * RoleResponse constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->item = RoleDto::createFromRole($role);
    }

    /**
     * @return RoleDto
     */
    public function getItem(): RoleDto
    {
        return $this->item;
    }
}
