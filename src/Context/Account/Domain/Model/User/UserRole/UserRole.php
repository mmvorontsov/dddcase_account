<?php

namespace App\Context\Account\Domain\Model\User\UserRole;

use App\Context\Account\Domain\Common\Type\Uuid;
use Exception;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\User;

/**
 * Class UserRole
 * @package App\Context\Account\Domain\Model\User\UserRole
 */
final class UserRole
{
    /**
     * @var User
     */
    private User $user;

    /**
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * @var RoleId
     */
    private RoleId $roleId;

    /**
     * UserRole constructor.
     * @param User $user
     * @param Uuid $uuid
     * @param RoleId $roleId
     */
    public function __construct(User $user, Uuid $uuid, RoleId $roleId)
    {
        $this->user = $user;
        $this->uuid = $uuid;
        $this->roleId = $roleId;
    }

    /**
     * @param User $user
     * @param RoleId $roleId
     * @return UserRole
     * @throws Exception
     */
    public static function create(User $user, RoleId $roleId): UserRole
    {
        return new self($user, Uuid::create(), $roleId);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return RoleId
     */
    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }
}
