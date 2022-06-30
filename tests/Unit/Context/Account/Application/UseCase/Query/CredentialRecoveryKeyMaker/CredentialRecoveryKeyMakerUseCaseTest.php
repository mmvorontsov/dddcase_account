<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker\{
    CredentialRecoveryKeyMakerRequest,
    CredentialRecoveryKeyMakerRequestValidatorInterface,
    CredentialRecoveryKeyMakerResponse,
    CredentialRecoveryKeyMakerResponseAssemblerInterface,
    CredentialRecoveryKeyMakerUseCase,
};
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use PHPUnit\Framework\TestCase;

/**
 * Class CredentialRecoveryKeyMakerUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
class CredentialRecoveryKeyMakerUseCaseTest extends TestCase
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
        $validatorMock = $this->createMock(CredentialRecoveryKeyMakerRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $responseAssemblerMock = $this->createMock(CredentialRecoveryKeyMakerResponseAssemblerInterface::class);
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturn($this->createMock(CredentialRecoveryKeyMakerResponse::class));

        $keyMakerAdditionMock = $this->createMock(KeyMakerAdditionInterface::class);
        $keyMakerAdditionMock->expects(self::once())
            ->method('findKeyMakerOfCredentialRecoveryOrNotFound')
            ->willReturn($this->createMock(CredentialRecoveryKeyMaker::class));

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new CredentialRecoveryKeyMakerUseCase(
            $validatorMock,
            $responseAssemblerMock,
            $keyMakerAdditionMock,
            $validatorAdditionMock,
        );

        $request = new CredentialRecoveryKeyMakerRequest();
        $request->setCredentialRecoveryId('b46bbdcb-8714-4ed3-ab78-d5b029647213');

        $useCase->execute($request);
    }
}
