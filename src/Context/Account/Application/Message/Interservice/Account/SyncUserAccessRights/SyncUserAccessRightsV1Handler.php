<?php

namespace App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights;

use Exception;
use App\Context\Account\AccountContext;
use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights\Reply\{
    SyncUserAccessRightsV1Reply,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Permission\PermissionId;
use App\Context\Account\Domain\Model\Permission\PermissionRepositoryInterface;
use App\Context\Account\Domain\Model\Permission\PermissionSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Permission\Remove\RemovePermissionServiceInterface;
use App\Context\Account\Domain\Model\Role\Remove\RemoveRoleServiceInterface;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\Role\RolePermission\RolePermission;
use App\Context\Account\Domain\Model\Role\RoleRepositoryInterface;
use App\Context\Account\Domain\Model\Role\RoleSelectionSpecFactoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

use function array_diff;
use function array_diff_key;
use function array_intersect_key;
use function array_keys;
use function array_push;

/**
 * Class SyncUserAccessRightsV1Handler
 * @package App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights
 */
class SyncUserAccessRightsV1Handler implements InterserviceCommandHandlerInterface
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
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * @var PermissionSelectionSpecFactoryInterface
     */
    private PermissionSelectionSpecFactoryInterface $permissionSelectionSpecFactory;

    /**
     * @var RemovePermissionServiceInterface
     */
    private RemovePermissionServiceInterface $removePermissionService;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * @var RemoveRoleServiceInterface
     */
    private RemoveRoleServiceInterface $removeRoleService;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var array
     */
    private array $protectedUserRoles;

    /**
     * SyncUserAccessRightsV1Handler constructor.
     * @param PermissionRepositoryInterface $permissionRepository
     * @param RoleSelectionSpecFactoryInterface $roleSelectionSpecFactory
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionSelectionSpecFactoryInterface $permissionSelectionSpecFactory
     * @param RemovePermissionServiceInterface $removePermissionService
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param OutboxQueueManagerInterface $outboxQueueManager
     * @param RemoveRoleServiceInterface $removeRoleService
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        PermissionRepositoryInterface $permissionRepository,
        RoleSelectionSpecFactoryInterface $roleSelectionSpecFactory,
        RoleRepositoryInterface $roleRepository,
        PermissionSelectionSpecFactoryInterface $permissionSelectionSpecFactory,
        RemovePermissionServiceInterface $removePermissionService,
        InboxHistoryManagerInterface $inboxHistoryManager,
        OutboxQueueManagerInterface $outboxQueueManager,
        RemoveRoleServiceInterface $removeRoleService,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->permissionRepository = $permissionRepository;
        $this->roleSelectionSpecFactory = $roleSelectionSpecFactory;
        $this->roleRepository = $roleRepository;
        $this->permissionSelectionSpecFactory = $permissionSelectionSpecFactory;
        $this->removePermissionService = $removePermissionService;
        $this->removeRoleService = $removeRoleService;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->outboxQueueManager = $outboxQueueManager;
        $this->transactionalSession = $transactionalSession;
        $this->protectedUserRoles = ProtectedUserRoleEnum::toArray();
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param SyncUserAccessRightsV1 $message
     */
    public function __invoke(SyncUserAccessRightsV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->updateUserAccessRights($message);
            $this->createReply($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }

    /**
     * @param SyncUserAccessRightsV1 $message
     * @throws Exception
     */
    private function createReply(SyncUserAccessRightsV1 $message): void
    {
        $this->outboxQueueManager->add(
            SyncUserAccessRightsV1Reply::create($message)
        );
    }

    /**
     * @param SyncUserAccessRightsV1 $message
     * @throws Exception
     */
    private function updateUserAccessRights(SyncUserAccessRightsV1 $message): void
    {
        $owner = $message->getContextId();
        $userAccessRights = $message->getUserAccessRights();

        $roles = $this->getIndexedRolesOf($owner);
        $permissions = $this->getIndexedPermissionsOf($owner);

        $rolesFromUserAccessRights = $this->getRolesFromUserAccessRights($userAccessRights, $owner);
        $permissionsFromUserAccessRights = $this->getPermissionsFromUserAccessRights($userAccessRights);
        $rolesToPermissionsFromUserAccessRights = $this->getRolesToPermissionsFromUserAccessRights($userAccessRights);

        $this->removeUnusedRoles($roles, $rolesFromUserAccessRights);
        $this->removeUnusedPermissions($permissions, $permissionsFromUserAccessRights);
        $this->updateUsedPermissions($permissions, $userAccessRights);
        $this->updateUsedRoles($roles, $rolesToPermissionsFromUserAccessRights);
        $this->addNewPermissions($permissions, $userAccessRights, $owner);
        $this->addNewRoles($roles, $rolesFromUserAccessRights, $rolesToPermissionsFromUserAccessRights, $owner);
    }

    /**
     * @param string $owner
     * @return array
     */
    private function getIndexedRolesOf(string $owner): array
    {
        $roles = $this->roleRepository->selectSatisfying(
            $this->roleSelectionSpecFactory->createBelongsToOwnerSelectionSpec($owner)
        );

        foreach ($roles as $role) {
            $indexedRoles[$role->getRoleId()->getValue()] = $role;
        }

        return $indexedRoles ?? [];
    }

    /**
     * @param string $owner
     * @return array
     */
    private function getIndexedPermissionsOf(string $owner): array
    {
        $permissions = $this->permissionRepository->selectSatisfying(
            $this->permissionSelectionSpecFactory->createBelongsToOwnerSelectionSpec($owner)
        );

        /** @var Permission $permission */
        foreach ($permissions as $permission) {
            $indexedPermissions[$permission->getPermissionId()->getValue()] = $permission;
        }

        return $indexedPermissions ?? [];
    }

    /**
     * @param array $accessRights
     * @param string $owner
     * @return array
     */
    private function getRolesFromUserAccessRights(array $accessRights, string $owner): array
    {
        $roles = [];
        foreach ($accessRights as $permissionData) {
            $permissionRoles = $permissionData['roles'] ?? [];
            array_push($roles, ...$permissionRoles);
        }

        $roles = array_unique($roles);
        if (AccountContext::CONTEXT_ID !== $owner) {
            $roles = array_diff_key($roles, $this->protectedUserRoles);
        }

        return $roles;
    }

    /**
     * @param array $accessRights
     * @return array
     */
    private function getPermissionsFromUserAccessRights(array $accessRights): array
    {
        return array_keys($accessRights);
    }

    /**
     * @param array $accessRights
     * @return array
     */
    private function getRolesToPermissionsFromUserAccessRights(array $accessRights): array
    {
        foreach ($accessRights as $permissionId => $permissionData) {
            $roles = $permissionData['roles'] ?? [];
            foreach ($roles as $roleId) {
                $rolesToPermissions[$roleId][$permissionId] = $permissionId;
            }
        }

        return $rolesToPermissions ?? [];
    }

    /**
     * @param array $ownerRoles
     * @param array $rolesFromUserAccessRights
     */
    private function removeUnusedRoles(array $ownerRoles, array $rolesFromUserAccessRights): void
    {
        $rolesToRemove = array_diff_key($ownerRoles, array_flip($rolesFromUserAccessRights));
        if (!empty($rolesToRemove)) {
            $this->removeRoleService->executeForAll($rolesToRemove);
        }
    }

    /**
     * @param array $ownerPermissions
     * @param array $permissionsFromUserAccessRights
     */
    private function removeUnusedPermissions(array $ownerPermissions, array $permissionsFromUserAccessRights): void
    {
        $permissionsToRemove = array_diff_key($ownerPermissions, array_flip($permissionsFromUserAccessRights));
        if (!empty($permissionsToRemove)) {
            $this->removePermissionService->executeForAll($permissionsToRemove);
        }
    }

    /**
     * @param array $ownerPermissions
     * @param array $userAccessRights
     */
    private function updateUsedPermissions(array $ownerPermissions, array $userAccessRights): void
    {
        $permissionsToUpdate = array_intersect_key($ownerPermissions, $userAccessRights);
        if (empty($permissionsToUpdate)) {
            return;
        }

        /** @var Permission $permission */
        foreach ($permissionsToUpdate as $permission) {
            $description = $userAccessRights[$permission->getPermissionId()->getValue()]['description'] ?? '';
            $permission->updateDescription($description);
        }
    }

    /**
     * @param array $ownerRoles
     * @param array $rolesToPermissionsFromUserAccessRights
     * @throws Exception
     */
    private function updateUsedRoles(array $ownerRoles, array $rolesToPermissionsFromUserAccessRights): void
    {
        /** @var Role $role */
        foreach ($ownerRoles as $role) {
            $rolePermissions = $role->getRolePermissions();
            $permissions = $rolesToPermissionsFromUserAccessRights[$role->getRoleId()->getValue()] ?? [];

            if (!empty($rolePermissions)) {
                /** @var RolePermission $rolePermission */
                foreach ($rolePermissions as $rolePermission) {
                    if (!isset($permissions[$rolePermission->getPermissionId()->getValue()])) {
                        $role->removeRolePermission($rolePermission->getPermissionId());
                    }
                }
            }

            if (!empty($permissions)) {
                foreach ($permissions as $permissionId) {
                    $role->addRolePermission(PermissionId::createFrom($permissionId));
                }
            }
        }
    }

    /**
     * @param array $ownerPermissions
     * @param array $userAccessRights
     * @param string $owner
     */
    private function addNewPermissions(array $ownerPermissions, array $userAccessRights, string $owner): void
    {
        $permissionsToAdd = array_diff_key($userAccessRights, $ownerPermissions);
        if (empty($permissionsToAdd)) {
            return;
        }

        foreach ($permissionsToAdd as $permissionId => $permissionData) {
            $permission = Permission::create(
                PermissionId::createFrom($permissionId),
                $permissionData['description'] ?? '',
                $owner
            );
            $this->permissionRepository->add($permission);
        }
    }

    /**
     * @param array $ownerRoles
     * @param array $rolesFromUserAccessRights
     * @param array $rolesToPermissionsFromUserAccessRights
     * @param string $owner
     * @throws Exception
     */
    private function addNewRoles(
        array $ownerRoles,
        array $rolesFromUserAccessRights,
        array $rolesToPermissionsFromUserAccessRights,
        string $owner
    ): void {
        $rolesToAdd = array_diff($rolesFromUserAccessRights, array_keys($ownerRoles));
        if (empty($rolesToAdd)) {
            return;
        }

        foreach ($rolesToAdd as $roleId) {
            $role = Role::create(RoleId::createFrom($roleId), $owner);
            $permissions = $rolesToPermissionsFromUserAccessRights[$role->getRoleId()->getValue()] ?? [];
            if (!empty($permissions)) {
                foreach ($permissions as $permissionId) {
                    $role->addRolePermission(PermissionId::createFrom($permissionId));
                }
            }
            $this->roleRepository->add($role);
        }
    }
}
