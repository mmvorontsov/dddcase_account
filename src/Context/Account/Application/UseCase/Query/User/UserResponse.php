<?php

namespace App\Context\Account\Application\UseCase\Query\User;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\User\UserDto;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class UserResponse
 * @package App\Context\Account\Application\UseCase\Query\User
 */
final class UserResponse
{
    /**
     * @var UserDto
     */
    private UserDto $item;

    /**
     * UserResponse constructor.
     * @param User $item
     */
    public function __construct(User $item)
    {
        $this->item = UserDto::createFromUser($item);
    }

    /**
     * @return UserDto
     */
    public function getItem(): UserDto
    {
        return $this->item;
    }
}
