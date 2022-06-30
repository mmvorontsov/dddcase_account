<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\User\UserDto;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class UserByCredentialResponse
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
final class UserByCredentialResponse
{
    /**
     * @var UserDto
     */
    private UserDto $item;

    /**
     * UserByCredentialResponse constructor.
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
