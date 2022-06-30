<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\User\UserDto;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class UpdateUserResponse
 * @package App\Context\Account\Application\UseCase\Command\UpdateUser
 */
final class UpdateUserResponse
{
    /**
     * @var UserDto
     */
    private UserDto $item;

    /**
     * UpdateUserResponse constructor.
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
