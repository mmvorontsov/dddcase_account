<?php

namespace App\Context\Account\Application\Security\AccessControl;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ServiceRoleEnum;

/**
 * Class AccessRightsMapping
 * @package App\Context\Account\Application\Security\AccessControl
 */
final class AccessRightsMapping
{
    /**
     * @var array|array[]
     */
    private static array $userAccessRights = [
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USERS_READ => [
            'description' => 'Read users',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_READ => [
            'description' => 'Read user',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_PERMISSIONS_READ => [
            'description' => 'Read user permissions',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_UPDATE => [
            'description' => 'Update user',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_ROLES_UPDATE => [
            'description' => 'Update user roles',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_CREATE => [
            'description' => 'Create user contact data change',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_KEY_MAKER_READ => [
            'description' => 'Read contact data change key maker',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_SECRET_CODE_CREATE => [
            'description' => 'Create contact data change secret code',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_SIGN => [
            'description' => 'Sign contact data change',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__ROLES_READ => [
            'description' => 'Read roles',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__ROLE_READ => [
            'description' => 'Read role',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_PASSWORD_UPDATE => [
            'description' => 'Update user credential password update',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CONTACT_DATA_READ => [
            'description' => 'Read user contact data',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
        UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_READ => [
            'description' => 'Read user credential',
            'roles' => [
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__ADMIN,
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        ],
    ];

    /**
     * @var array|array[]
     */
    private static array $serviceAccessRights = [
        ServiceRoleEnum::ROLE__SERVICE__BASE => [
            UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_READ,
            UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_READ_BY_CREDENTIAL,
            UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_READ,
            UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CONTACT_DATA_READ,
        ]
    ];

    /**
     * @return array
     */
    public static function getUserAccessRights(): array
    {
        return self::$userAccessRights;
    }

    /**
     * @return array
     */
    public static function getServiceAccessRights(): array
    {
        return self::$serviceAccessRights;
    }
}
