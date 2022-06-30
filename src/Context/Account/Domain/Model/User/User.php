<?php

namespace App\Context\Account\Domain\Model\User;

use App\Context\Account\Domain\Common\Util\ArrayUtil;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\AggregateRootInterface;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\Update\UpdateUserCommand;
use App\Context\Account\Domain\Model\User\Update\UserRolesUpdated;
use App\Context\Account\Domain\Model\User\UserRole\UserRole;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

/**
 * Class User
 * @package App\Context\Account\Domain\Model\User
 */
class User implements AggregateRootInterface
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var string
     */
    private string $firstname;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection
     */
    private Collection $userRoles;

    /**
     * User constructor.
     * @param UserId $userId
     * @param string $firstname
     * @param DateTimeImmutable $createdAt
     * @param Collection $userRoles
     */
    public function __construct(
        UserId $userId,
        string $firstname,
        DateTimeImmutable $createdAt,
        Collection $userRoles,
    ) {
        $this->userId = $userId;
        $this->firstname = $firstname;
        $this->createdAt = $createdAt;
        $this->userRoles = $userRoles;
    }

    /**
     * @param CreateUserCommand $command
     * @return User
     * @throws Exception
     */
    public static function create(CreateUserCommand $command): User
    {
        $user = new self(
            UserId::create(),
            $command->getFirstname(),
            new DateTimeImmutable(),
            new ArrayCollection(),
        );

        $roleIds = $command->getRoleIds();

        foreach ($roleIds as $roleId) {
            if (!$roleId instanceof RoleId) {
                throw new DomainException('Failed to assign role. Unexpected role ID type');
            }
            $userRole = UserRole::create($user, $roleId);
            $user->userRoles->set($roleId->getValue(), $userRole);
        }

        // TODO Check role ids of new user
        DomainEventSubject::instance()->notify(
            new UserCreated($user),
        );

        return $user;
    }

    /**
     * @param UpdateUserCommand $command
     */
    public function update(UpdateUserCommand $command): void
    {
        $updateMethods = [
            UpdateUserCommand::FIRSTNAME => function (string $firstname) {
                $this->setFirstname($firstname);
            },
            UpdateUserCommand::ROLE_IDS => function (array $roleIds) {
                $this->updateUserRoles($roleIds);
            },
        ];

        foreach ($command->all() as $propKey => $args) {
            if ($updateMethod = $updateMethods[$propKey] ?? null) {
                $updateMethod(...$args);
            }
        }
    }

    /**
     * @param RoleId $roleId
     * @throws Exception
     */
    public function removeUserRole(RoleId $roleId): void
    {
        $this->userRoles->remove($roleId->getValue());
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    /**
     * @param array $roleIds
     * @throws Exception
     */
    private function updateUserRoles(array $roleIds): void
    {
        $this->setUserRoles($roleIds);

        DomainEventSubject::instance()->notify(
            new UserRolesUpdated($this),
        );
    }

    /**
     * @param string $firstname
     */
    private function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @param array $roleIds
     * @throws Exception
     */
    private function setUserRoles(array $roleIds): void
    {
        $currentRoleIds = $this->getUserRoles()
            ->map(fn(UserRole $userRole) => $userRole->getRoleId())
            ->toArray();

        $intersectedRoleIds = ArrayUtil::stringIdsIntersect($roleIds, $currentRoleIds);
        $roleIdsToRemove = ArrayUtil::stringIdsDiff($currentRoleIds, $intersectedRoleIds);
        $roleIdsToAdd = ArrayUtil::stringIdsDiff($roleIds, $intersectedRoleIds);

        /** @var RoleId $roleIdToRemove */
        foreach ($roleIdsToRemove as $roleIdToRemove) {
            $this->removeUserRole($roleIdToRemove);
        }

        /** @var RoleId $roleIdToAdd */
        foreach ($roleIdsToAdd as $roleIdToAdd) {
            $this->addUserRole($roleIdToAdd);
        }
    }

    /**
     * @param RoleId $roleId
     * @throws Exception
     */
    private function addUserRole(RoleId $roleId): void
    {
        if (null === $this->userRoles->get($roleId->getValue())) {
            $userRole = UserRole::create($this, $roleId);
            $this->userRoles->set($roleId->getValue(), $userRole);
        }
    }
}
