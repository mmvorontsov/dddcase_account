<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\CredentialRecoveryAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword\EnterCredentialRecoveryPasswordCommand;
use App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword\{
    EnterCredentialRecoveryPasswordRequest,
    EnterCredentialRecoveryPasswordRequestValidatorInterface as RequestValidatorInterface,
    EnterCredentialRecoveryPasswordResponse,
    EnterCredentialRecoveryPasswordResponseAssemblerInterface as ResponseAssemblerInterface,
    EnterCredentialRecoveryPasswordUseCase,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword\EnterCredentialRecoveryPasswordServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class EnterCredentialRecoveryPasswordUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
class EnterCredentialRecoveryPasswordUseCaseTest extends TestCase
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
        $validatorMock = $this->createMock(RequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $credentialRecoveryMock = $this->createMock(CredentialRecovery::class);
        $credentialRecoveryMock->expects(self::once())
            ->method('getPasswordEntryCode')
            ->willReturn('password_entry_code');

        $credentialRecoveryAdditionMock = $this->createMock(CredentialRecoveryAdditionInterface::class);
        $credentialRecoveryAdditionMock->expects(self::once())
            ->method('findByIdOrNotFound')
            ->willReturn($credentialRecoveryMock);

        $passwordHasherMock = $this->createMock(PasswordHasherInterface::class);
        $passwordHasherMock->expects(self::once())
            ->method('hash')
            ->willReturn('hashed_password');

        $enterPasswordServiceMock = $this->createMock(
            EnterCredentialRecoveryPasswordServiceInterface::class,
        );
        $enterPasswordServiceMock->expects(self::once())->method('execute');

        $responseAssemblerMock = $this->createMock(ResponseAssemblerInterface::class);
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($credentialRecovery) {
                    self::assertInstanceOf(CredentialRecovery::class, $credentialRecovery);
                    return $this->createMock(EnterCredentialRecoveryPasswordResponse::class);
                },
            );

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    $callback();
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new EnterCredentialRecoveryPasswordUseCase(
            $validatorMock,
            $enterPasswordServiceMock,
            $responseAssemblerMock,
            $passwordHasherMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $credentialRecoveryAdditionMock,
            $validatorAdditionMock,
        );

        $request = new EnterCredentialRecoveryPasswordRequest();
        $request->setCredentialRecoveryId('b46bbdcb-8714-4ed3-ab78-d5b029647213');
        $request->setPasswordEntryCode('password_entry_code');
        $request->setPassword('password');

        $useCase->execute($request);
    }
}
