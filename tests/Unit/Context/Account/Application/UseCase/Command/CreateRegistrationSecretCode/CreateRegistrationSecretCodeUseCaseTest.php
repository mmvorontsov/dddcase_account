<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\RegistrationAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode\{
    CreateRegistrationSecretCodeRequest,
    CreateRegistrationSecretCodeRequestValidatorInterface as RequestValidatorInterface,
    CreateRegistrationSecretCodeResponse,
    CreateRegistrationSecretCodeResponseAssemblerInterface as ResponseAssemblerInterface,
    CreateRegistrationSecretCodeUseCase,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateRegistrationSecretCodeUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
class CreateRegistrationSecretCodeUseCaseTest extends TestCase
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

        $registrationKeyMakerMock = $this->createMock(RegistrationKeyMaker::class);
        $registrationKeyMakerMock->expects(self::once())->method('createSecretCode');
        $registrationKeyMakerMock->expects(self::once())
            ->method('getSecretCodes')
            ->willReturn(new ArrayCollection([$this->createMock(SecretCode::class)]));

        $keyMakerAdditionMock = $this->createMock(KeyMakerAdditionInterface::class);
        $keyMakerAdditionMock->expects(self::once())
            ->method('findKeyMakerOfRegistrationOrNotFound')
            ->willReturn($registrationKeyMakerMock);

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
                    return $this->createMock(CreateRegistrationSecretCodeResponse::class);
                },
            );

        $registrationAdditionMock = $this->createMock(RegistrationAdditionInterface::class);
        $registrationAdditionMock->expects(self::once())->method('repositoryContainsIdOrNotFound');

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new CreateRegistrationSecretCodeUseCase(
            $validatorMock,
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $keyMakerAdditionMock,
            $registrationAdditionMock,
            $validatorAdditionMock,
        );

        $request = new CreateRegistrationSecretCodeRequest();
        $request->setRegistrationId('3dd3e50e-2b4b-4b6e-b607-b63d2edd8151');

        $useCase->execute($request);
    }
}
