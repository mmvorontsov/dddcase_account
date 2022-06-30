<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\Permission\Remove;

use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Permission\Permission;
use App\Context\Account\Domain\Model\Permission\PermissionRepositoryInterface;
use App\Context\Account\Domain\Model\Permission\Remove\RemovePermissionService;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RemovePermissionServiceTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\Permission\Remove
 */
class RemovePermissionServiceTest extends TestCase
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
    public function testSuccessfulRemovingForOne(): void
    {
        $permissionRepositoryMock = $this->createMock(PermissionRepositoryInterface::class);
        $permissionRepositoryMock->expects(self::once())
            ->method('remove')
            ->willReturnCallback(
                function ($permission) {
                    self::assertInstanceOf(Permission::class, $permission);
                }
            );

        $removePermissionService = new RemovePermissionService($permissionRepositoryMock);
        $removePermissionService->execute($this->createMock(Permission::class));
    }

    /**
     * @throws Exception
     */
    public function testSuccessfulRemovingForAll(): void
    {
        $permissionRepositoryMock = $this->createMock(PermissionRepositoryInterface::class);
        $permissionRepositoryMock->expects(self::exactly(3))
            ->method('remove')
            ->willReturnCallback(
                function ($permission) {
                    self::assertInstanceOf(Permission::class, $permission);
                }
            );

        $removePermissionService = new RemovePermissionService($permissionRepositoryMock);
        $removePermissionService->executeForAll(
            [
                $this->createMock(Permission::class),
                $this->createMock(Permission::class),
                $this->createMock(Permission::class),
            ]
        );
    }
}
