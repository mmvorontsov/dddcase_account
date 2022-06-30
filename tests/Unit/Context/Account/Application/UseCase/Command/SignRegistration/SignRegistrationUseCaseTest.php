<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\UseCase\Addition\RegistrationAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationRequest;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationRequestValidatorInterface;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationResponse;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationResponseAssemblerInterface;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationUseCase;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Service\SignRegistration\SignRegistrationServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class SignRegistrationUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Command\SignRegistration
 */
class SignRegistrationUseCaseTest extends TestCase
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
        $validatorMock = $this->createMock(SignRegistrationRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $signRegistrationServiceMock = $this->createMock(SignRegistrationServiceInterface::class);
        $signRegistrationServiceMock->expects(self::once())
            ->method('execute')
            ->willReturn($this->createMock(Registration::class));

        $transactionalSessionMock = $this->createMock(TransactionalSessionInterface::class);
        $transactionalSessionMock->expects(self::once())
            ->method('executeAtomically')
            ->willReturnCallback(
                function ($callback) {
                    return $callback();
                },
            );

        $responseAssemblerMock = $this->createMock(SignRegistrationResponseAssemblerInterface::class);
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturn($this->createMock(SignRegistrationResponse::class));

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new SignRegistrationUseCase(
            $validatorMock,
            $signRegistrationServiceMock,
            $this->createMock(KeyMakerRepositoryInterface::class), // TODO
            $responseAssemblerMock,
            $transactionalSessionMock,
            $this->createMock(DomainEventObserverInterface::class),
            $this->createMock(RegistrationAdditionInterface::class), // TODO
            $validatorAdditionMock,
        );

        $request = new SignRegistrationRequest();
        $request->setRegistrationId('b46bbdcb-8714-4ed3-ab78-d5b029647213');
        $request->setSecretCode('123456');

        $useCase->execute($request);
    }
}
