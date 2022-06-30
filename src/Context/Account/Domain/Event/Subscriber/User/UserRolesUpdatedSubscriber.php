<?php

namespace App\Context\Account\Domain\Event\Subscriber\User;

use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\Subscriber\DomainEventSubscriberInterface;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\Role\RoleRepositoryInterface;
use App\Context\Account\Domain\Model\Role\RoleSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\User\Update\UserRolesUpdated;
use App\Context\Account\Domain\Model\User\UserRole\UserRole;

use function array_map;
use function implode;
use function in_array;
use function sprintf;

/**
 * Class UserRolesUpdatedSubscriber
 * @package App\Context\Account\Domain\Event\Subscriber\User
 */
final class UserRolesUpdatedSubscriber implements DomainEventSubscriberInterface
{
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;

    /**
     * @var RoleSelectionSpecFactoryInterface
     */
    private RoleSelectionSpecFactoryInterface $roleSelectionSpecFactory;

    /**
     * UserRolesUpdatedSubscriber constructor.
     * @param RoleRepositoryInterface $roleRepository
     * @param RoleSelectionSpecFactoryInterface $roleSelectionSpecFactory
     */
    public function __construct(RoleRepositoryInterface $roleRepository, RoleSelectionSpecFactoryInterface $roleSelectionSpecFactory)
    {
        $this->roleRepository = $roleRepository;
        $this->roleSelectionSpecFactory = $roleSelectionSpecFactory;
    }

    /**
     * @param UserRolesUpdated $event
     */
    public function __invoke(UserRolesUpdated $event): void
    {
        $this->checkRolesExistence($event);
    }

    /**
     * @param UserRolesUpdated $event
     */
    private function checkRolesExistence(UserRolesUpdated $event): void
    {
        /** @var RoleId[] $roleIds */
        $roleIds = $event->getUser()
            ->getUserRoles()
            ->map(fn(UserRole $userRole) => $userRole->getRoleId())
            ->getValues();

        $roles = $this->roleRepository->selectSatisfying(
            $this->roleSelectionSpecFactory->createIsOneOfRoleIdsSelectionSpec($roleIds)
        );

        $existingRoleIds = array_map(
            fn(Role $role) => $role->getRoleId()->getValue(),
            $roles
        );
        $notExistentRoleIds = [];

        foreach ($roleIds as $roleId) {
            if (!in_array($roleId->getValue(), $existingRoleIds, true)) {
                $notExistentRoleIds[] = $roleId->getValue();
            }
        }

        if (!empty($notExistentRoleIds)) {
            throw new DomainException(
                sprintf('Roles %s does not exist.', implode(', ', $notExistentRoleIds))
            );
        }
    }
}
