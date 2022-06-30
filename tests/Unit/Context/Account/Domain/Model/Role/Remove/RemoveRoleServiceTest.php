<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\Role\Remove;

use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Role\Remove\RemoveRoleService;
use App\Context\Account\Domain\Model\Role\Remove\RoleRemoved;
use App\Context\Account\Domain\Model\Role\Role;
use App\Context\Account\Domain\Model\Role\RoleRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RemoveRoleServiceTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\Role\Remove
 */
class RemoveRoleServiceTest extends TestCase
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
        $roleRepositoryMock = $this->createMock(RoleRepositoryInterface::class);
        $roleRepositoryMock->expects(self::once())
            ->method('remove')
            ->willReturnCallback(
                function ($role) {
                    self::assertInstanceOf(Role::class, $role);
                }
            );

        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::once())
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                }
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $removeRoleService = new RemoveRoleService($roleRepositoryMock);
        $removeRoleService->execute($this->createMock(Role::class));

        self::assertCount(1, $events);
        self::assertInstanceOf(RoleRemoved::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testSuccessfulRemovingForAll(): void
    {
        $roleRepositoryMock = $this->createMock(RoleRepositoryInterface::class);
        $roleRepositoryMock->expects(self::exactly(3))
            ->method('remove')
            ->willReturnCallback(
                function ($role) {
                    self::assertInstanceOf(Role::class, $role);
                }
            );

        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::exactly(3))
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                }
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $removeRoleService = new RemoveRoleService($roleRepositoryMock);
        $removeRoleService->executeForAll(
            [
                $this->createMock(Role::class),
                $this->createMock(Role::class),
                $this->createMock(Role::class),
            ]
        );

        self::assertCount(3, $events);
        self::assertInstanceOf(RoleRemoved::class, $events[0]);
        self::assertInstanceOf(RoleRemoved::class, $events[1]);
        self::assertInstanceOf(RoleRemoved::class, $events[2]);
    }
}
