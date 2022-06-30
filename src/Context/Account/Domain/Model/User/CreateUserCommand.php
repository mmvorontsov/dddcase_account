<?php

namespace App\Context\Account\Domain\Model\User;

use App\Context\Account\Domain\Model\Role\RoleId;

/**
 * Class CreateUserCommand
 * @package App\Context\Account\Domain\Model\User
 */
final class CreateUserCommand
{
    /**
     * @var string
     */
    private string $firstname;

    /**
     * @var RoleId[]
     */
    private array $roleIds;

    /**
     * CreateUserCommand constructor.
     * @param string $firstname
     * @param array $roleIds
     */
    public function __construct(string $firstname, array $roleIds)
    {
        $this->firstname = $firstname;
        $this->roleIds = $roleIds;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return RoleId[]
     */
    public function getRoleIds(): array
    {
        return $this->roleIds;
    }
}
