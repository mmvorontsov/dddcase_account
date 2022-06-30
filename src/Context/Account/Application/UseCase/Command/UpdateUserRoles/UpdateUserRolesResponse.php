<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\User\UserDto;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class UpdateUserRolesResponse
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 */
final class UpdateUserRolesResponse
{
    /**
     * @var UserDto
     */
    private UserDto $item;

    /**
     * UpdateUserRolesResponse constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->item = UserDto::createFromUser($user);
    }

    /**
     * @return UserDto
     */
    public function getItem(): UserDto
    {
        return $this->item;
    }
}
