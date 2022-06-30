<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\Credential;

use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Credential\CreateCredentialCommand;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialCreated;
use App\Context\Account\Domain\Model\User\UserId;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class CredentialTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\Credential
 */
class CredentialTest extends TestCase
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

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $credential = Credential::create(
            new CreateCredentialCommand(
                $userId,
                'tom',
                'hashed_password'
            )
        );

        self::assertSame('tom', $credential->getUsername());
        self::assertSame('hashed_password', $credential->getHashedPassword());
        self::assertTrue($credential->getUserId()->isEqualTo($userId));
        self::assertEmpty($credential->getPasswordHistory()->toArray());
        self::assertCount(1, $events);
        self::assertInstanceOf(CredentialCreated::class, $events[0]);
    }
}
