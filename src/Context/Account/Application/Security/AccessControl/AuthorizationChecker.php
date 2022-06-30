<?php

namespace App\Context\Account\Application\Security\AccessControl;

use App\Context\Account\Infrastructure\Security\SecurityInterface;

use function array_filter;
use function array_intersect;
use function array_keys;
use function array_push;
use function array_unique;
use function count;

/**
 * Class AuthorizationChecker
 * @package App\Context\Account\Application\Security\AccessControl
 */
final class AuthorizationChecker implements AuthorizationCheckerInterface
{
    /**
     * @var array
     */
    private array $userAccessRights;

    /**
     * @var array
     */
    private array $serviceAccessRights;

    /**
     * @var array
     */
    private array $clientRoles;

    /**
     * @var array
     */
    private array $clientPermissions;

    /**
     * AuthorizationChecker constructor.
     * @param SecurityInterface $security
     */
    public function __construct(SecurityInterface $security)
    {
        $this->userAccessRights = AccessRightsMapping::getUserAccessRights();
        $this->serviceAccessRights = AccessRightsMapping::getServiceAccessRights();
        $this->clientRoles = $security->getClient()->getRoles() ?? [];
        $this->clientPermissions = $this->getClientPermissions($this->clientRoles);
    }

    /**
     * If false you must throw exception Forbidden "No access right to perform action"
     *
     * @param array $permissions
     * @return bool
     */
    public function can(array $permissions): bool
    {
        $intersection = array_intersect($permissions, $this->clientPermissions);

        return count($intersection) === count($permissions);
    }

    /**
     * If false you must throw exception Forbidden "No access right to perform action"
     *
     * @param array $permissions
     * @return bool
     */
    public function canOr(array $permissions): bool
    {
        return !empty(array_intersect($permissions, $this->clientPermissions));
    }

    /**
     * If false you must throw exception Forbidden "No access right to perform action"
     *
     * @param array $roles
     * @return bool
     */
    public function be(array $roles): bool
    {
        $intersection = array_intersect($roles, $this->clientRoles);

        return count($intersection) === count($roles);
    }

    /**
     * If false you must throw exception Forbidden "No access right to perform action"
     *
     * @param array $roles
     * @return bool
     */
    public function beOr(array $roles): bool
    {
        return !empty(array_intersect($roles, $this->clientRoles));
    }

    /**
     * @param array $clientRoles
     * @return array
     */
    private function getClientPermissions(array $clientRoles): array
    {
        $clientPermissions = array_keys(
            array_filter(
                $this->userAccessRights,
                static function (array $permissionData) use ($clientRoles) {
                    return !empty(array_intersect($clientRoles, $permissionData['roles'] ?? []));
                }
            )
        );

        foreach ($clientRoles as $clientRole) {
            array_push($clientPermissions, ...($this->serviceAccessRights[$clientRole] ?? []));
        }

        return array_unique($clientPermissions);
    }
}
