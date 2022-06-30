<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode\{
    CreateCredentialRecoverySecretCodeRequest,
    CreateCredentialRecoverySecretCodeRequestValidatorInterface as RequestValidatorInterface,
    CreateCredentialRecoverySecretCodeResponse,
    CreateCredentialRecoverySecretCodeResponseAssemblerInterface as ResponseAssemblerInterface,
    CreateCredentialRecoverySecretCodeUseCase,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateCredentialRecoverySecretCodeUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
class CreateCredentialRecoverySecretCodeUseCaseTest extends TestCase
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

        $credentialRecoveryKeyMakerMock = $this->createMock(CredentialRecoveryKeyMaker::class);
        $credentialRecoveryKeyMakerMock->expects(self::once())->method('createSecretCode');
        $credentialRecoveryKeyMakerMock->expects(self::once())
            ->method('getLastSecretCode')
            ->willReturn($this->createMock(SecretCode::class));

        $keyMakerAdditionMock = $this->createMock(KeyMakerAdditionInterface::class);
        $keyMakerAdditionMock->expects(self::once())
            ->method('findKeyMakerOfCredentialRecoveryOrNotFound')
            ->willReturn($credentialRecoveryKeyMakerMock);

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $responseAssemblerMock = $this->createMock(ResponseAssemblerInterface::class);
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturnCallback(
                function ($secretCode) {
                    self::assertInstanceOf(SecretCode::class, $secretCode);
                    return $this->createMock(CreateCredentialRecoverySecretCodeResponse::class);
                },
            );

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new CreateCredentialRecoverySecretCodeUseCase(
            $validatorMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $keyMakerAdditionMock,
            $validatorAdditionMock,
        );

        $request = new CreateCredentialRecoverySecretCodeRequest();
        $request->setCredentialRecoveryId('3dd3e50e-2b4b-4b6e-b607-b63d2edd8151');

        $useCase->execute($request);
    }
}
