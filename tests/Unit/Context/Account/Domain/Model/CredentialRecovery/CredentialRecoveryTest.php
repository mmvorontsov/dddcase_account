<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\CredentialRecovery;

use App\Context\Account\Application\Common\StringUtil;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryCreated;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

/**
 * Class CredentialRecoveryTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\CredentialRecovery
 */
class CredentialRecoveryTest extends TestCase
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
                },
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $credentialRecovery = CredentialRecovery::create(
            EmailAddress::createFrom('tom@example.com'),
            $userId,
        );

        self::assertSame('tom@example.com', $credentialRecovery->getByEmail()->getValue());
        self::assertNull($credentialRecovery->getByPhone());
        self::assertSame('fddacf9e-50de-4878-bdc1-60bfb5c9d14e', $credentialRecovery->getUserId()->getValue());
        self::assertSame('SIGNING', $credentialRecovery->getStatus());
        self::assertNull($credentialRecovery->getPasswordEntryCode());
        self::assertCount(1, $events);
        self::assertInstanceOf(CredentialRecoveryCreated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testCreateWithNullUser(): void
    {
        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::exactly(1))
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                },
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $credentialRecovery = CredentialRecovery::create(
            EmailAddress::createFrom('tom@example.com'),
            null,
        );

        self::assertSame('tom@example.com', $credentialRecovery->getByEmail()->getValue());
        self::assertNull($credentialRecovery->getByPhone());
        self::assertNull($credentialRecovery->getUserId());
        self::assertSame('SIGNING', $credentialRecovery->getStatus());
        self::assertNull($credentialRecovery->getPasswordEntryCode());
        self::assertCount(1, $events);
        self::assertInstanceOf(CredentialRecoveryCreated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testSignWhenCredentialRecoveryIsExpired(): void
    {
        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::never())->method('notify');

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $credentialRecovery = new CredentialRecovery(
            $userId,
            CredentialRecoveryId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14a'),
            EmailAddress::createFrom('tom@example.com'),
            null,
            'SIGNING',
            null,
            new DateTimeImmutable(sprintf('-%d seconds', CredentialRecovery::LIFETIME + 1)),
            new DateTimeImmutable('-1 seconds'),
        );

        self::assertSame('SIGNING', $credentialRecovery->getStatus());
        self::assertNull($credentialRecovery->getPasswordEntryCode());

        self::expectException(DomainException::class);
        self::expectExceptionMessage('Credential recovery has expired.');

        $credentialRecovery->sign();
    }

    /**
     * @throws Exception
     */
    public function testSignWhenCredentialRecoveryHasInvalidStatusForSigning(): void
    {
        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::never())->method('notify');

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $credentialRecovery = new CredentialRecovery(
            $userId,
            CredentialRecoveryId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14a'),
            EmailAddress::createFrom('tom@example.com'),
            null,
            'DONE', // <---
            null,
            new DateTimeImmutable(),
            new DateTimeImmutable(sprintf('+%d seconds', CredentialRecovery::LIFETIME)),
        );

        self::assertSame('DONE', $credentialRecovery->getStatus());
        self::assertNull($credentialRecovery->getPasswordEntryCode());

        self::expectException(DomainException::class);
        self::expectExceptionMessage('Credential recovery has invalid status for signing.');

        $credentialRecovery->sign();
    }

    /**
     * @throws Exception
     */
    public function testSign(): void
    {
        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::never())->method('notify');

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $credentialRecovery = new CredentialRecovery(
            $userId,
            CredentialRecoveryId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14a'),
            EmailAddress::createFrom('tom@example.com'),
            null,
            'SIGNING',
            null,
            new DateTimeImmutable(),
            new DateTimeImmutable('+2 days'),
        );

        self::assertSame('SIGNING', $credentialRecovery->getStatus());
        self::assertNull($credentialRecovery->getPasswordEntryCode());

        $credentialRecovery->sign();

        self::assertSame('PASSWORD_ENTRY', $credentialRecovery->getStatus());
        self::assertNotNull($credentialRecovery->getPasswordEntryCode());
    }

    /**
     * @throws Exception
     */
    public function testEnterPassword(): void
    {
        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::never())->method('notify');

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        $passwordEntryCode = StringUtil::generate(CredentialRecovery::PASSWORD_ENTRY_CODE_LENGTH);
        $credentialRecovery = new CredentialRecovery(
            $userId,
            CredentialRecoveryId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14a'),
            EmailAddress::createFrom('tom@example.com'),
            null,
            'PASSWORD_ENTRY',
            $passwordEntryCode,
            new DateTimeImmutable(),
            new DateTimeImmutable('+2 days'),
        );

        self::assertSame('PASSWORD_ENTRY', $credentialRecovery->getStatus());
        self::assertSame($passwordEntryCode, $credentialRecovery->getPasswordEntryCode());

        $credentialRecovery->enterPassword($passwordEntryCode);

        self::assertSame('DONE', $credentialRecovery->getStatus());
        self::assertSame($passwordEntryCode, $credentialRecovery->getPasswordEntryCode());
    }
}
