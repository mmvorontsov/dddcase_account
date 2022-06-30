<?php

namespace App\Context\Account\Domain\Model\User;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;

/**
 * Class UserCreated
 * @package App\Context\Account\Domain\Model\User
 */
final class UserCreated extends DomainEvent
{
    /**
     * @var User
     */
    private User $user;

    /**
     * UserCreated constructor.
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
