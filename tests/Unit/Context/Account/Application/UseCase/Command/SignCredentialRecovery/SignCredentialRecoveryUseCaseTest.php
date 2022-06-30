<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\CredentialRecoveryAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\SignCredentialRecovery\{
    SignCredentialRecoveryRequest,
    SignCredentialRecoveryRequestValidatorInterface,
    SignCredentialRecoveryResponse,
    SignCredentialRecoveryResponseAssemblerInterface,
    SignCredentialRecoveryUseCase,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Service\SignCredentialRecovery\SignCredentialRecoveryServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class SignCredentialRecoveryUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
class SignCredentialRecoveryUseCaseTest extends TestCase
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
        $validatorMock = $this->createMock(SignCredentialRecoveryRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $signCredentialRecoveryServiceMock = $this->createMock(SignCredentialRecoveryServiceInterface::class);
        $signCredentialRecoveryServiceMock->expects(self::once())
            ->method('execute')
            ->willReturn($this->createMock(CredentialRecovery::class));

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $responseAssemblerMock = $this->createMock(
            SignCredentialRecoveryResponseAssemblerInterface::class,
        );
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturn($this->createMock(SignCredentialRecoveryResponse::class));

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new SignCredentialRecoveryUseCase(
            $validatorMock,
            $signCredentialRecoveryServiceMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $this->createMock(CredentialRecoveryAdditionInterface::class), // TODO
            $this->createMock(KeyMakerAdditionInterface::class),
            $validatorAdditionMock,
        );

        $request = new SignCredentialRecoveryRequest();
        $request->setCredentialRecoveryId('b46bbdcb-8714-4ed3-ab78-d5b029647213');
        $request->setSecretCode('123456');

        $useCase->execute($request);
    }
}
