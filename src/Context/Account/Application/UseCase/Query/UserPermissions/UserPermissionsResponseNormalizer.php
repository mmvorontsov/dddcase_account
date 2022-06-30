<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

use App\Context\Account\Application\Security\AccessControl\AuthorizationCheckerInterface;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\UseCase\Assembly\Output\Model\Permission\PermissionDto;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class UserPermissionsResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 */
final class UserPermissionsResponseNormalizer implements UserPermissionsResponseNormalizerInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private AuthorizationCheckerInterface $authorizationChecker;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param UserPermissionsResponse $response
     * @return array
     */
    #[ArrayShape(['items' => "array|array[]"])]
    public function toArray(UserPermissionsResponse $response): array
    {
        // TODO
        return [
            'items' => array_map(
                function (PermissionDto $item) {
                    return $this->normalizeItem($item);
                },
                $response->getItems()
            ),
        ];
    }

    /**
     * @param PermissionDto $permissionDto
     * @return array
     */
    private function normalizeItem(PermissionDto $permissionDto): array
    {
        $item = [
            'permissionId' => $permissionDto->getPermissionId(),
            'description' => $permissionDto->getDescription(),
        ];

        $ownerRoles = [
            ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
            ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
        ];

        if ($this->authorizationChecker->beOr($ownerRoles)) {
            $item['owner'] = $permissionDto->getOwner();
        }

        return $item;
    }
}
