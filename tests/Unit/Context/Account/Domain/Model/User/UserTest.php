<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\User;

use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\CreateUserCommand;
use App\Context\Account\Domain\Model\User\Update\UpdateUserCommand;
use App\Context\Account\Domain\Model\User\Update\UserRolesUpdated;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserCreated;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Domain\Model\User\UserRole\UserRole;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\User
 */
class UserTest extends TestCase
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
        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::exactly(1))
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                }
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $roleId = RoleId::createFrom('ROLE__USER');
        $user = User::create(new CreateUserCommand('Tom', [$roleId]));

        $userRoleIds = $user->getUserRoles()->map(
            static fn(UserRole $userRole) => $userRole->getRoleId()->getValue()
        )->getValues();

        self::assertSame('Tom', $user->getFirstname());
        self::assertContains($roleId->getValue(), $userRoleIds);
        self::assertCount(1, $events);
        self::assertInstanceOf(UserCreated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testUpdateFirstname(): void
    {
        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $user = new User($userId, 'Tom', new DateTimeImmutable(), new ArrayCollection());

        self::assertSame('Tom', $user->getFirstname());

        $command = new UpdateUserCommand();
        $command->setFirstname('Jerry');
        $user->update($command);

        self::assertSame('Jerry', $user->getFirstname());
    }

    /**
     * @throws Exception
     */
    public function testUpdateAndRemoveRoleIds(): void
    {
        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::exactly(1))
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                }
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $user = new User($userId, 'Tom', new DateTimeImmutable(), new ArrayCollection());

        self::assertSame(0, $user->getUserRoles()->count());

        $roleId = RoleId::createFrom('ROLE__USER');
        $command = new UpdateUserCommand();
        $command->setRoleIds([$roleId]);
        $user->update($command);

        self::assertSame(1, $user->getUserRoles()->count());

        $userRoleIds = $user->getUserRoles()->map(
            static fn(UserRole $userRole) => $userRole->getRoleId()->getValue()
        )->getValues();

        self::assertContains($roleId->getValue(), $userRoleIds);
        self::assertCount(1, $events);
        self::assertInstanceOf(UserRolesUpdated::class, $events[0]);

        $user->removeUserRole($roleId);
        self::assertSame(0, $user->getUserRoles()->count());
    }
}
