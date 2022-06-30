<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\Role;

use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Permission\PermissionId;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RolePermission\RolePermission;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RoleTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\Role
 */
class RoleTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        DomainEventSubject::instance()->unregisterAllObservers();
    }

    /**
     * @throws Exception
     */
    public function testCreate(): void
    {
        $role = Role::create('ROLE__USER', 'context_id');
        $rolePermissionIds = $role->getRolePermissions()->map(
            static fn(RolePermission $rolePermission) => $rolePermission->getPermissionId()->getValue()
        )->getValues();

        self::assertSame('ROLE__USER', $role->getRoleId()->getValue());
        self::assertSame('context_id', $role->getOwner());
        self::assertCount(0, $rolePermissionIds);
    }

    /**
     * @throws Exception
     */
    public function testAddAndRemoveRolePermission(): void
    {
        $role = Role::create('ROLE__USER', 'context_id');

        $permissionId = PermissionId::createFrom('PERMISSION__USER_READ');
        $role->addRolePermission($permissionId);

        $permissionIds = $role->getRolePermissions()->map(
            static fn(RolePermission $rolePermission) => $rolePermission->getPermissionId()->getValue()
        )->getValues();

        self::assertContains($permissionId->getValue(), $permissionIds);
        self::assertCount(1, $permissionIds);

        $role->removeRolePermission($permissionId);
        self::assertSame(0, $role->getRolePermissions()->count());
    }
}
