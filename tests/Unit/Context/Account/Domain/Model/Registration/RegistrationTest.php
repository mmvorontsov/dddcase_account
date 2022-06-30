<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\Registration;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Registration\CreateRegistrationCommand;
use App\Context\Account\Domain\Model\Registration\PersonalData;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationCreated;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Registration\RegistrationStatusEnum;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RegistrationTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\Registration
 */
class RegistrationTest extends TestCase
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

        $createRegistrationCommand = new CreateRegistrationCommand(
            'Tom',
            'hashed_password',
            EmailAddress::createFrom('tom@example.com'),
        );
        $registration = Registration::create($createRegistrationCommand);

        self::assertSame('SIGNING', $registration->getStatus());

        self::assertSame('Tom', $registration->getPersonalData()->getFirstname());
        self::assertSame('hashed_password', $registration->getPersonalData()->getHashedPassword());
        self::assertSame('tom@example.com', $registration->getPersonalData()->getEmail()->getValue());
        self::assertCount(1, $events);
        self::assertInstanceOf(RegistrationCreated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testSignWhenRegistrationIsExpired(): void
    {
        $registration = new Registration(
            RegistrationId::create(),
            new PersonalData(
                'Tom',
                'hashed_password',
                EmailAddress::createFrom('tom@example.com'),
            ),
            RegistrationStatusEnum::SIGNING,
            new DateTimeImmutable('-' . Registration::LIFETIME + 1 . ' seconds'),
            new DateTimeImmutable('-1 seconds'),
        );

        self::expectException(DomainException::class);
        self::expectExceptionMessage('Registration has expired.');

        $registration->sign();
    }

    /**
     * @throws Exception
     */
    public function testSignWhenRegistrationHasInvalidStatusForSigning(): void
    {
        $registration = new Registration(
            RegistrationId::create(),
            new PersonalData(
                'Tom',
                'hashed_password',
                EmailAddress::createFrom('tom@example.com'),
            ),
            RegistrationStatusEnum::DONE, // <---
            new DateTimeImmutable(),
            new DateTimeImmutable('+' . Registration::LIFETIME . ' seconds'),
        );

        self::expectException(DomainException::class);
        self::expectExceptionMessage('Registration has invalid status for signing.');

        $registration->sign();
    }

    /**
     * @throws Exception
     */
    public function testSign(): void
    {
        $registration = new Registration(
            RegistrationId::create(),
            new PersonalData(
                'Tom',
                'hashed_password',
                EmailAddress::createFrom('tom@example.com'),
            ),
            RegistrationStatusEnum::SIGNING,
            new DateTimeImmutable(),
            new DateTimeImmutable('+' . Registration::LIFETIME . ' seconds'),
        );

        self::assertSame('SIGNING', $registration->getStatus());

        $registration->sign();
        self::assertSame('DONE', $registration->getStatus());
    }
}
