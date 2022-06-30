<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\{
    CreateCredentialRecoveryRequestValidatorInterface,
    CreateCredentialRecoveryResponse,
    CreateCredentialRecoveryResponseAssemblerInterface,
    CreateCredentialRecoveryUseCase,
    Request\CreateCredentialRecoveryByEmailRequest,
    Request\CreateCredentialRecoveryByPhoneRequest,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Service\CreateCredentialRecovery\CreateCredentialRecoveryCommand;
use App\Context\Account\Domain\Service\CreateCredentialRecovery\CreateCredentialRecoveryServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateCredentialRecoveryUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
class CreateCredentialRecoveryUseCaseTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        DomainEventSubject::instance()->unregisterAllObservers();
    }

    public function testExecuteSuccessfullyWhenEmailPassed(): void
    {
        $validatorMock = $this->createMock(CreateCredentialRecoveryRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $serviceMock = $this->createMock(CreateCredentialRecoveryServiceInterface::class);
        $serviceMock->expects(self::once())
            ->method('execute')
            ->willReturnCallback(
                function ($command) {
                    self::assertInstanceOf(CreateCredentialRecoveryCommand::class, $command);
                    return $this->createMock(CredentialRecovery::class);
                },
            );

        $responseAssemblerMock = $this->createMock(
            CreateCredentialRecoveryResponseAssemblerInterface::class,
        );
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($credentialRecovery) {
                    self::assertInstanceOf(CredentialRecovery::class, $credentialRecovery);
                    return $this->createMock(CreateCredentialRecoveryResponse::class);
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new CreateCredentialRecoveryUseCase(
            $validatorMock,
            $serviceMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $validatorAdditionMock,
        );

        $request = new CreateCredentialRecoveryByEmailRequest();
        $request->setType('EMAIL');
        $request->setByEmail('tom@example.com');

        $useCase->execute($request);
    }

    public function testExecuteSuccessfullyWhenPhonePassed(): void
    {
        $validatorMock = $this->createMock(CreateCredentialRecoveryRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $serviceMock = $this->createMock(CreateCredentialRecoveryServiceInterface::class);
        $serviceMock->expects(self::once())
            ->method('execute')
            ->willReturnCallback(
                function ($command) {
                    self::assertInstanceOf(CreateCredentialRecoveryCommand::class, $command);
                    return $this->createMock(CredentialRecovery::class);
                },
            );

        $responseAssemblerMock = $this->createMock(
            CreateCredentialRecoveryResponseAssemblerInterface::class,
        );
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($credentialRecovery) {
                    self::assertInstanceOf(CredentialRecovery::class, $credentialRecovery);
                    return $this->createMock(CreateCredentialRecoveryResponse::class);
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new CreateCredentialRecoveryUseCase(
            $validatorMock,
            $serviceMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $validatorAdditionMock,
        );

        $request = new CreateCredentialRecoveryByPhoneRequest();
        $request->setType('PHONE');
        $request->setByPhone('+12345678901');

        $useCase->execute($request);
    }
}
