<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ContactDataAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\{
    CreateContactDataChangeRequestValidatorInterface,
    CreateContactDataChangeResponse,
    CreateContactDataChangeResponseAssemblerInterface,
    CreateContactDataChangeUseCase,
    Request\CreateEmailChangeRequest,
    Request\CreatePhoneChangeRequest,
};
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeRepositoryInterface;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Client\User;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateContactDataChangeUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
class CreateContactDataChangeUseCaseTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        DomainEventSubject::instance()->unregisterAllObservers();
    }

    public function testExecuteSuccessfullyWhenEmailGiven(): void
    {
        $authorizationCheckerMock = $this->createMock(AuthorizationCheckerAdditionInterface::class);
        $authorizationCheckerMock->expects(self::once())->method('canOrForbidden');

        $userMock = $this->createMock(User::class);
        $userMock->expects(self::once())
            ->method('getId')
            ->willReturn('06411094-f591-44b2-bb4a-5fab0c697fc1');

        $securityAdditionMock = $this->createMock(SecurityAdditionInterface::class);
        $securityAdditionMock->expects(self::once())
            ->method('getAuthenticatedUserOrForbidden')
            ->willReturn($userMock);

        $validatorMock = $this->createMock(CreateContactDataChangeRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturnCallback(
                function ($request) {
                    self::assertInstanceOf(CreateEmailChangeRequest::class, $request);
                    return new ErrorList([]);
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())
            ->method('isEmptyErrorListOrUnprocessableEntity');

        $userAdditionMock = $this->createMock(UserAdditionInterface::class);
        $userAdditionMock->expects(self::once())
            ->method('repositoryContainsIdOrForbidden');

        $contactDataMock = $this->createMock(ContactData::class);
        $contactDataMock->expects(self::once())
            ->method('getUserId')
            ->willReturn(UserId::createFrom('06411094-f591-44b2-bb4a-5fab0c697fc1'));
        $contactDataMock->expects(self::once())
            ->method('getEmail')
            ->willReturn(EmailAddress::createFrom('email@example.com'));

        $contactDataAdditionMock = $this->createMock(ContactDataAdditionInterface::class);
        $contactDataAdditionMock->expects(self::once())
            ->method('findContactDataOfUserOrNotFound')
            ->willReturnCallback(
                function ($userId) use ($contactDataMock) {
                    self::assertInstanceOf(UserId::class, $userId);
                    self::assertSame('06411094-f591-44b2-bb4a-5fab0c697fc1', $userId->getValue());
                    return $contactDataMock;
                },
            );

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $responseAssemblerMock = $this->createMock(
            CreateContactDataChangeResponseAssemblerInterface::class,
        );
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($contactDataChange) {
                    self::assertInstanceOf(ContactDataChange::class, $contactDataChange);
                    return $this->createMock(CreateContactDataChangeResponse::class);
                },
            );

        $contactDataChangeRepositoryMock = $this->createMock(ContactDataChangeRepositoryInterface::class);
        $contactDataChangeRepositoryMock->expects(self::once())
            ->method('add')
            ->willReturnCallback(
                function ($contactDataChange) {
                    self::assertInstanceOf(ContactDataChange::class, $contactDataChange);
                },
            );

        $useCase = new CreateContactDataChangeUseCase(
            $validatorMock,
            $contactDataChangeRepositoryMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $contactDataAdditionMock,
            $authorizationCheckerMock,
            $securityAdditionMock,
            $userAdditionMock,
            $validatorAdditionMock,
        );

        $request = new CreateEmailChangeRequest();
        $request->setToEmail('to@example.com');
        $useCase->execute($request);
    }

    public function testExecuteSuccessfullyWhenPhoneGiven(): void
    {
        $authorizationCheckerMock = $this->createMock(AuthorizationCheckerAdditionInterface::class);
        $authorizationCheckerMock->expects(self::once())->method('canOrForbidden');

        $userMock = $this->createMock(User::class);
        $userMock->expects(self::once())
            ->method('getId')
            ->willReturn('06411094-f591-44b2-bb4a-5fab0c697fc1');

        $securityAdditionMock = $this->createMock(SecurityAdditionInterface::class);
        $securityAdditionMock->expects(self::once())
            ->method('getAuthenticatedUserOrForbidden')
            ->willReturn($userMock);

        $validatorMock = $this->createMock(CreateContactDataChangeRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturnCallback(
                function ($request) {
                    self::assertInstanceOf(CreatePhoneChangeRequest::class, $request);
                    return new ErrorList([]);
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())
            ->method('isEmptyErrorListOrUnprocessableEntity');

        $userAdditionMock = $this->createMock(UserAdditionInterface::class);
        $userAdditionMock->expects(self::once())
            ->method('repositoryContainsIdOrForbidden');

        $contactDataMock = $this->createMock(ContactData::class);
        $contactDataMock->expects(self::once())
            ->method('getUserId')
            ->willReturn(UserId::createFrom('06411094-f591-44b2-bb4a-5fab0c697fc1'));
        $contactDataMock->expects(self::once())
            ->method('getPhone')
            ->willReturn(PhoneNumber::createFrom('+10000000001'));

        $contactDataAdditionMock = $this->createMock(ContactDataAdditionInterface::class);
        $contactDataAdditionMock->expects(self::once())
            ->method('findContactDataOfUserOrNotFound')
            ->willReturnCallback(
                function ($userId) use ($contactDataMock) {
                    self::assertInstanceOf(UserId::class, $userId);
                    self::assertSame('06411094-f591-44b2-bb4a-5fab0c697fc1', $userId->getValue());
                    return $contactDataMock;
                },
            );

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $responseAssemblerMock = $this->createMock(
            CreateContactDataChangeResponseAssemblerInterface::class,
        );
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($contactDataChange) {
                    self::assertInstanceOf(ContactDataChange::class, $contactDataChange);
                    return $this->createMock(CreateContactDataChangeResponse::class);
                },
            );

        $contactDataChangeRepositoryMock = $this->createMock(ContactDataChangeRepositoryInterface::class);
        $contactDataChangeRepositoryMock->expects(self::once())
            ->method('add')
            ->willReturnCallback(
                function ($contactDataChange) {
                    self::assertInstanceOf(ContactDataChange::class, $contactDataChange);
                },
            );

        $useCase = new CreateContactDataChangeUseCase(
            $validatorMock,
            $contactDataChangeRepositoryMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $contactDataAdditionMock,
            $authorizationCheckerMock,
            $securityAdditionMock,
            $userAdditionMock,
            $validatorAdditionMock,
        );

        $request = new CreatePhoneChangeRequest();
        $request->setToPhone('+10000000002');
        $useCase->execute($request);
    }
}
