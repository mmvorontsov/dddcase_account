<?php

namespace App\Context\Account\Domain\Model\User\Update;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class UserCreated
 * @package App\Context\Account\Domain\Model\User
 */
final class UserRolesUpdated extends DomainEvent
{
    /**
     * @var User
     */
    private User $user;

    /**
     * UserRolesUpdated constructor.
     * @param User $user
     * @throws Exception
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
