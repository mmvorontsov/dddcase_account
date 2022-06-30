<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Application\UseCase\Command\CreateRegistration\{
    CreateRegistrationRequest,
    CreateRegistrationRequestValidatorInterface,
    CreateRegistrationResponse,
    CreateRegistrationResponseAssemblerInterface,
    CreateRegistrationUseCase,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Registration\RegistrationRepositoryInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateRegistrationUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Action\Client\Command\CreateRegistration
 */
class CreateRegistrationUseCaseTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        DomainEventSubject::instance()->unregisterAllObservers();
    }

    public function testExecuteSuccessfully(): void
    {
        $validatorMock = $this->createMock(CreateRegistrationRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $repositoryMock = $this->createMock(RegistrationRepositoryInterface::class);
        $repositoryMock->expects(self::once())->method('add');

        $passwordHasherMock = $this->createMock(PasswordHasherInterface::class);
        $passwordHasherMock->expects(self::once())
            ->method('hash')
            ->willReturnCallback(
                function (string $plainPassword): string {
                    return $plainPassword . '_hashed_password';
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

        $responseAssemblerMock = $this->createMock(CreateRegistrationResponseAssemblerInterface::class);
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($registration) {
                    self::assertInstanceOf(Registration::class, $registration);
                    return $this->createMock(CreateRegistrationResponse::class);
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new CreateRegistrationUseCase(
            $validatorMock,
            $repositoryMock,
            $responseAssemblerMock,
            $passwordHasherMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $validatorAdditionMock,
        );

        $request = new CreateRegistrationRequest();
        $request->setFirstname('Tom');
        $request->setPassword('password');
        $request->setEmail('tom@example.com');

        $useCase->execute($request);
    }
}
