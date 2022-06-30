<?php

namespace App\Tests\Unit\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataCreated;
use App\Context\Account\Domain\Model\ContactData\ContactDataId;
use App\Context\Account\Domain\Model\ContactData\CreateContactDataCommand;
use App\Context\Account\Domain\Model\ContactData\EmailHistory\EmailHistory;
use App\Context\Account\Domain\Model\ContactData\PhoneHistory\PhoneHistory;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataEmailUpdated;
use App\Context\Account\Domain\Model\ContactData\Update\ContactDataPhoneUpdated;
use App\Context\Account\Domain\Model\ContactData\Update\UpdateContactDataCommand;
use App\Context\Account\Domain\Model\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactDataTest
 * @package App\Tests\Unit\Context\Account\Domain\Model\ContactData
 */
class ContactDataTest extends TestCase
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
        $contactData = ContactData::create(
            new CreateContactDataCommand(
                $userId,
                EmailAddress::createFrom('tom@example.com'),
                null,
            ),
        );

        self::assertSame('tom@example.com', $contactData->getEmail()->getValue());
        self::assertNull($contactData->getPhone());
        self::assertSame('fddacf9e-50de-4878-bdc1-60bfb5c9d14e', $contactData->getUserId()->getValue());
        self::assertEmpty($contactData->getEmailHistory()->toArray());
        self::assertEmpty($contactData->getPhoneHistory()->toArray());
        self::assertCount(1, $events);
        self::assertInstanceOf(ContactDataCreated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testCreateWithInvalidCommand(): void
    {
        self::expectException(DomainException::class);
        self::expectErrorMessage('Email or phone number must be specified.');

        $userId = UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e');
        ContactData::create(
            new CreateContactDataCommand($userId, null, null),
        );
    }

    /**
     * @throws Exception
     */
    public function testUpdateEmail(): void
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

        $contactData = new ContactData(
            UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'),
            ContactDataId::create(),
            EmailAddress::createFrom('tom@example.com'),
            null,
            new DateTimeImmutable('-1 year'),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        self::assertSame('tom@example.com', $contactData->getEmail()->getValue());
        self::assertNull($contactData->getPhone());
        self::assertEmpty($contactData->getEmailHistory()->toArray());
        self::assertEmpty($contactData->getPhoneHistory()->toArray());

        $updateContactDataCommand = new UpdateContactDataCommand();
        $updateContactDataCommand->setEmail(EmailAddress::createFrom('tom2@example.com'));

        $contactData->update($updateContactDataCommand);

        self::assertSame('tom2@example.com', $contactData->getEmail()->getValue());
        self::assertNull($contactData->getPhone());
        self::assertCount(1, $contactData->getEmailHistory());
        self::assertEmpty($contactData->getPhoneHistory()->toArray());

        /** @var EmailHistory $emailHistory */
        $emailHistory = $contactData->getEmailHistory()->last();

        self::assertSame('tom@example.com', $emailHistory->getEmail()->getValue());

        self::assertCount(1, $events);
        self::assertInstanceOf(ContactDataEmailUpdated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testUpdatePhone(): void
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

        $contactData = new ContactData(
            UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'),
            ContactDataId::create(),
            null,
            PhoneNumber::createFrom('+12345678901'),
            new DateTimeImmutable('-1 year'),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        self::assertNull($contactData->getEmail());
        self::assertSame('+12345678901', $contactData->getPhone()->getValue());
        self::assertEmpty($contactData->getEmailHistory()->toArray());
        self::assertEmpty($contactData->getPhoneHistory()->toArray());

        $updateContactDataCommand = new UpdateContactDataCommand();
        $updateContactDataCommand->setPhone(PhoneNumber::createFrom('+12345678000'));

        $contactData->update($updateContactDataCommand);

        self::assertNull($contactData->getEmail());
        self::assertSame('+12345678000', $contactData->getPhone()->getValue());
        self::assertEmpty($contactData->getEmailHistory()->toArray());
        self::assertCount(1, $contactData->getPhoneHistory());

        /** @var PhoneHistory $phoneHistory */
        $phoneHistory = $contactData->getPhoneHistory()->last();

        self::assertSame('+12345678901', $phoneHistory->getPhone()->getValue());

        self::assertCount(1, $events);
        self::assertInstanceOf(ContactDataPhoneUpdated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testUpdateEmailWhenHistoryLimitReached(): void
    {
        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::once())
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                },
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $contactData = new ContactData(
            UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'),
            ContactDataId::create(),
            EmailAddress::createFrom('tom0@example.com'),
            null,
            new DateTimeImmutable('-1 year'),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        self::assertSame('tom0@example.com', $contactData->getEmail()->getValue());
        self::assertEmpty($contactData->getEmailHistory()->toArray());

        $historyLength = ContactData::EMAIL_HISTORY_LENGTH;
        while ($historyLength > 0) {
            $days = ContactData::EMAIL_HISTORY_LENGTH - $historyLength + 1;
            $contactData->getEmailHistory()->add(
                new EmailHistory(
                    $contactData,
                    Uuid::create(),
                    EmailAddress::createFrom(sprintf('tom%d@example.com', $historyLength)),
                    $contactData->getCreatedAt()->modify(sprintf('+%d days', $days)),
                ),
            );
            $historyLength--;
        }

        self::assertSame('tom0@example.com', $contactData->getEmail()->getValue());
        self::assertCount(ContactData::EMAIL_HISTORY_LENGTH, $contactData->getEmailHistory());

        /** @var EmailHistory $lastEmailHistory */
        $lastEmailHistory = $contactData->getEmailHistory()->last();
        self::assertSame('tom1@example.com', $lastEmailHistory->getEmail()->getValue());

        $updateContactDataCommand = new UpdateContactDataCommand();
        $updateContactDataCommand->setEmail(EmailAddress::createFrom('tom01@example.com'));
        $contactData->update($updateContactDataCommand);

        self::assertSame('tom01@example.com', $contactData->getEmail()->getValue());
        self::assertCount(ContactData::EMAIL_HISTORY_LENGTH, $contactData->getEmailHistory());

        /** @var EmailHistory $lastEmailHistory */
        $lastEmailHistory = $contactData->getEmailHistory()->last();
        self::assertSame('tom0@example.com', $lastEmailHistory->getEmail()->getValue());

        self::assertCount(1, $events);
        self::assertInstanceOf(ContactDataEmailUpdated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testUpdatePhoneWhenHistoryLimitReached(): void
    {
        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::once())
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                },
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $contactData = new ContactData(
            UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'),
            ContactDataId::create(),
            null,
            PhoneNumber::createFrom('+12345670000'),
            new DateTimeImmutable('-1 year'),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        self::assertSame('+12345670000', $contactData->getPhone()->getValue());
        self::assertEmpty($contactData->getPhoneHistory()->toArray());

        $historyLength = ContactData::PHONE_HISTORY_LENGTH;
        while ($historyLength > 0) {
            $days = ContactData::PHONE_HISTORY_LENGTH - $historyLength + 1;
            $contactData->getPhoneHistory()->add(
                new PhoneHistory(
                    $contactData,
                    Uuid::create(),
                    PhoneNumber::createFrom(sprintf('+1234567000%d', $historyLength)),
                    $contactData->getCreatedAt()->modify(sprintf('+%d days', $days)),
                ),
            );
            $historyLength--;
        }

        self::assertSame('+12345670000', $contactData->getPhone()->getValue());
        self::assertCount(ContactData::PHONE_HISTORY_LENGTH, $contactData->getPhoneHistory());

        /** @var PhoneHistory $lastPhoneHistory */
        $lastPhoneHistory = $contactData->getPhoneHistory()->last();
        self::assertSame('+12345670001', $lastPhoneHistory->getPhone()->getValue());

        $updateContactDataCommand = new UpdateContactDataCommand();
        $updateContactDataCommand->setPhone(PhoneNumber::createFrom('+12345671001'));
        $contactData->update($updateContactDataCommand);

        self::assertSame('+12345671001', $contactData->getPhone()->getValue());
        self::assertCount(ContactData::PHONE_HISTORY_LENGTH, $contactData->getPhoneHistory());

        /** @var PhoneHistory $lastPhoneHistory */
        $lastPhoneHistory = $contactData->getPhoneHistory()->last();
        self::assertSame('+12345670000', $lastPhoneHistory->getPhone()->getValue());

        self::assertCount(1, $events);
        self::assertInstanceOf(ContactDataPhoneUpdated::class, $events[0]);
    }

    /**
     * @throws Exception
     */
    public function testUpdateEmailWhenDailyLimitReached(): void
    {
        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::never())->method('notify');

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $contactData = new ContactData(
            UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'),
            ContactDataId::create(),
            EmailAddress::createFrom('tom0@example.com'),
            null,
            new DateTimeImmutable(),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        self::assertSame('tom0@example.com', $contactData->getEmail()->getValue());
        self::assertEmpty($contactData->getEmailHistory()->toArray());

        $dailyLimit = ContactData::EMAIL_CHANGE_DAILY_LIMIT;
        while ($dailyLimit > 0) {
            $contactData->getEmailHistory()->add(
                new EmailHistory(
                    $contactData,
                    Uuid::create(),
                    EmailAddress::createFrom(sprintf('tom%d@example.com', $dailyLimit)),
                    new DateTimeImmutable(),
                ),
            );
            $dailyLimit--;
        }

        $emailChangeDailyLimit = ContactData::EMAIL_CHANGE_DAILY_LIMIT;

        self::assertSame('tom0@example.com', $contactData->getEmail()->getValue());
        self::assertCount($emailChangeDailyLimit, $contactData->getEmailHistory());

        /** @var EmailHistory $lastEmailHistory */
        $lastEmailHistory = $contactData->getEmailHistory()->last();
        self::assertSame('tom1@example.com', $lastEmailHistory->getEmail()->getValue());

        self::expectException(DomainException::class);
        self::expectExceptionMessage(
            sprintf('Email change daily limit (%d times) reached.', $emailChangeDailyLimit),
        );

        $updateContactDataCommand = new UpdateContactDataCommand();
        $updateContactDataCommand->setEmail(EmailAddress::createFrom('tom01@example.com'));
        $contactData->update($updateContactDataCommand);
    }

    /**
     * @throws Exception
     */
    public function testUpdatePhoneWhenDailyLimitReached(): void
    {
        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::never())->method('notify');

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $contactData = new ContactData(
            UserId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'),
            ContactDataId::create(),
            null,
            PhoneNumber::createFrom('+12345670000'),
            new DateTimeImmutable(),
            new ArrayCollection(),
            new ArrayCollection(),
        );

        self::assertSame('+12345670000', $contactData->getPhone()->getValue());
        self::assertEmpty($contactData->getPhoneHistory()->toArray());

        $dailyLimit = ContactData::PHONE_CHANGE_DAILY_LIMIT;
        while ($dailyLimit > 0) {
            $contactData->getPhoneHistory()->add(
                new PhoneHistory(
                    $contactData,
                    Uuid::create(),
                    PhoneNumber::createFrom(sprintf('+1234567000%d', $dailyLimit)),
                    new DateTimeImmutable(),
                ),
            );
            $dailyLimit--;
        }

        $phoneChangeDailyLimit = ContactData::EMAIL_CHANGE_DAILY_LIMIT;

        self::assertSame('+12345670000', $contactData->getPhone()->getValue());
        self::assertCount($phoneChangeDailyLimit, $contactData->getPhoneHistory());

        /** @var PhoneHistory $lastPhoneHistory */
        $lastPhoneHistory = $contactData->getPhoneHistory()->last();
        self::assertSame('+12345670001', $lastPhoneHistory->getPhone()->getValue());

        self::expectException(DomainException::class);
        self::expectExceptionMessage(
            sprintf('Phone change daily limit (%d times) reached.', $phoneChangeDailyLimit),
        );

        $updateContactDataCommand = new UpdateContactDataCommand();
        $updateContactDataCommand->setPhone(PhoneNumber::createFrom('+12345671001'));
        $contactData->update($updateContactDataCommand);
    }
}
