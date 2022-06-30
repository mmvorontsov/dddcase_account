<?php

namespace App\Tests\Unit\Context\Account\Domain\Service\SignRegistration;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\DomainException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataCreated;
use App\Context\Account\Domain\Model\ContactData\ContactDataRepositoryInterface;
use App\Context\Account\Domain\Model\Credential\Credential;
use App\Context\Account\Domain\Model\Credential\CredentialCreated;
use App\Context\Account\Domain\Model\Credential\CredentialRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecInterface;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use App\Context\Account\Domain\Model\Registration\PersonalData;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Registration\Sign\RegistrationSigned;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\User;
use App\Context\Account\Domain\Model\User\UserCreated;
use App\Context\Account\Domain\Model\User\UserRepositoryInterface;
use App\Context\Account\Domain\Service\SignRegistration\SignRegistrationCommand;
use App\Context\Account\Domain\Service\SignRegistration\SignRegistrationService;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class SignRegistrationServiceTest
 * @package App\Tests\Unit\Context\Account\Domain\Service\SignRegistration
 */
class SignRegistrationServiceTest extends TestCase
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
    public function testExecuteWhenRegistrationKeyMakerNotExists(): void
    {
        $keyMakerRepositoryMock = $this->createMock(KeyMakerRepositoryInterface::class);
        $keyMakerRepositoryMock->expects(self::once())
            ->method('selectOneSatisfying')
            ->willReturn(null); // <---

        $keyMakerSelectionSpecFactoryMock = $this->createMock(KeyMakerSelectionSpecFactoryInterface::class);
        $keyMakerSelectionSpecFactoryMock->expects(self::once())
            ->method('createBelongsToRegistrationSelectionSpec')
            ->willReturn($this->createMock(KeyMakerSelectionSpecInterface::class));

        $service = new SignRegistrationService(
            $keyMakerRepositoryMock,
            $keyMakerSelectionSpecFactoryMock,
            $this->createMock(UserRepositoryInterface::class),
            $this->createMock(CredentialRepositoryInterface::class),
            $this->createMock(ContactDataRepositoryInterface::class),
        );

        $registrationMock = $this->createMock(Registration::class);
        $registrationMock->expects(self::once())
            ->method('getRegistrationId')
            ->willReturn(RegistrationId::createFrom('fddacf9e-50de-4878-bdc1-60bfb5c9d14e'));

        $roleIds = [RoleId::createFrom('ROLE__USER')];
        $command = new SignRegistrationCommand($registrationMock, '000000', $roleIds);

        self::expectException(DomainException::class);
        self::expectExceptionMessage('Registration key maker not found.');

        $service->execute($command);
    }

    /**
     * @throws Exception
     */
    public function testExecute(): void
    {
        $registrationKeyMakerMock = $this->createMock(RegistrationKeyMaker::class);
        $registrationKeyMakerMock->expects(self::once())
            ->method('acceptLastSecretCode');

        $keyMakerRepositoryMock = $this->createMock(KeyMakerRepositoryInterface::class);
        $keyMakerRepositoryMock->expects(self::once())
            ->method('selectOneSatisfying')
            ->willReturn($registrationKeyMakerMock);

        $keyMakerSelectionSpecFactoryMock = $this->createMock(KeyMakerSelectionSpecFactoryInterface::class);
        $keyMakerSelectionSpecFactoryMock->expects(self::once())
            ->method('createBelongsToRegistrationSelectionSpec')
            ->willReturn($this->createMock(KeyMakerSelectionSpecInterface::class));

        $personalData = new PersonalData(
            'Tom',
            'hashed_password',
            EmailAddress::createFrom('tom@example.com'),
        );

        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $userRepositoryMock->expects(self::once())
            ->method('add')
            ->willReturnCallback(
                function (User $user) use ($personalData) {
                    self::assertSame($personalData->getFirstname(), $user->getFirstname());
                },
            );

        $credentialRepositoryMock = $this->createMock(CredentialRepositoryInterface::class);
        $credentialRepositoryMock->expects(self::once())
            ->method('add')
            ->willReturnCallback(
                function (Credential $credential) use ($personalData) {
                    self::assertSame($personalData->getHashedPassword(), $credential->getHashedPassword());
                },
            );

        $contactDataRepositoryMock = $this->createMock(ContactDataRepositoryInterface::class);
        $contactDataRepositoryMock->expects(self::once())
            ->method('add')
            ->willReturnCallback(
                function (ContactData $contactData) use ($personalData) {
                    self::assertTrue($contactData->getEmail()->isEqualTo($personalData->getEmail()));
                },
            );

        $service = new SignRegistrationService(
            $keyMakerRepositoryMock,
            $keyMakerSelectionSpecFactoryMock,
            $userRepositoryMock,
            $credentialRepositoryMock,
            $contactDataRepositoryMock,
        );

        $registrationId = RegistrationId::createFrom('b46bbdcb-8714-4ed3-ab78-d5b029647213');

        $registrationMock = $this->createMock(Registration::class);
        $registrationMock->expects(self::once())->method('getRegistrationId')->willReturn($registrationId);
        $registrationMock->expects(self::exactly(4))
            ->method('getPersonalData')
            ->willReturn($personalData);

        $roleIds = [RoleId::createFrom('ROLE__USER')];
        $command = new SignRegistrationCommand($registrationMock, '111111', $roleIds);

        $events = [];

        $domainEventObserverMock = $this->createMock(DomainEventObserverInterface::class);
        $domainEventObserverMock->expects(self::exactly(4))
            ->method('notify')
            ->willReturnCallback(
                function ($event) use (&$events) {
                    $events[] = $event;
                },
            );

        DomainEventSubject::instance()->registerObserver($domainEventObserverMock);

        $registration = $service->execute($command);

        self::assertCount(4, $events);
        self::assertInstanceOf(UserCreated::class, $events[0]);
        self::assertInstanceOf(CredentialCreated::class, $events[1]);
        self::assertInstanceOf(ContactDataCreated::class, $events[2]);
        self::assertInstanceOf(RegistrationSigned::class, $events[3]);

        $registrationPersonalData = $registration->getPersonalData();

        self::assertSame($personalData->getFirstname(), $registrationPersonalData->getFirstname());
        self::assertSame($personalData->getHashedPassword(), $registrationPersonalData->getHashedPassword());
        self::assertTrue($personalData->getEmail()->isEqualTo($registrationPersonalData->getEmail()));
    }
}
