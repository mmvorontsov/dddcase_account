<?php

namespace App\Context\Account\Domain\Model\User\Update;

use App\Context\Account\Domain\Model\Role\RoleId;

/**
 * Class UpdateUserCommand
 * @package App\Context\Account\Domain\Model\User\Update
 */
final class UpdateUserCommand
{
    public const FIRSTNAME = 'FIRSTNAME';
    public const ROLE_IDS = 'ROLE_IDS';

    /**
     * @var array<string, array>
     */
    private array $data = [];

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->data[self::FIRSTNAME] = [$firstname];
    }

    /**
     * @param RoleId[] $roleIds
     */
    public function setRoleIds(array $roleIds): void
    {
        $this->data[self::ROLE_IDS] = [$roleIds];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
