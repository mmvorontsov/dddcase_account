<?php

namespace App\Tests\Unit\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Application\Common\Error\ErrorList;
use App\Context\Account\Application\Common\Error\ValidationError\ValidationError;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\RegistrationAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker\RegistrationKeyMakerRequest;
use App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker\RegistrationKeyMakerRequestValidatorInterface;
use App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker\RegistrationKeyMakerResponse;
use App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker\RegistrationKeyMakerResponseAssemblerInterface;
use App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker\RegistrationKeyMakerUseCase;
use App\Context\Account\Application\UseCase\UnprocessableEntityException;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use PHPUnit\Framework\TestCase;

/**
 * Class RegistrationKeyMakerUseCaseTest
 * @package App\Tests\Unit\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
class RegistrationKeyMakerUseCaseTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        DomainEventSubject::instance()->unregisterAllObservers();
    }

    public function testExecuteWhenRequestIsNotValid(): void
    {
        $validatorMock = $this->createMock(RegistrationKeyMakerRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList([new ValidationError('Message.', 'path')]));

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())
            ->method('isEmptyErrorListOrUnprocessableEntity')
            ->willReturnCallback(
                function ($errorList) {
                    throw new UnprocessableEntityException($errorList); // <---
                },
            );

        $useCase = new RegistrationKeyMakerUseCase(
            $validatorMock,
            $this->createMock(RegistrationKeyMakerResponseAssemblerInterface::class),
            $this->createMock(KeyMakerAdditionInterface::class),
            $this->createMock(RegistrationAdditionInterface::class),
            $validatorAdditionMock,
        );

        self::expectException(UnprocessableEntityException::class);
        self::expectExceptionCode(422);
        self::expectExceptionMessage('Request data is not valid.');

        try {
            $useCase->execute(new RegistrationKeyMakerRequest());
        } catch (UnprocessableEntityException $exception) {
            $errors = $exception->getErrors();
            self::assertTrue($errors->hasErrors());
            $firstError = $errors->getFirstError();
            self::assertInstanceOf(ValidationError::class, $firstError);
            self::assertSame('Message.', $firstError->getMessage());
            self::assertSame('path', $firstError->getPath());
            throw $exception;
        }
    }

    public function testExecuteWhenRegistrationNotFound(): void
    {
        $validatorMock = $this->createMock(RegistrationKeyMakerRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $registrationAdditionMock = $this->createMock(RegistrationAdditionInterface::class);
        $registrationAdditionMock->expects(self::once())
            ->method('repositoryContainsIdOrNotFound')
            ->willReturnCallback(
                function () {
                    throw new NotFoundException('Registration data not found.'); // <---
                },
            );

        $useCase = new RegistrationKeyMakerUseCase(
            $validatorMock,
            $this->createMock(RegistrationKeyMakerResponseAssemblerInterface::class),
            $this->createMock(KeyMakerAdditionInterface::class),
            $registrationAdditionMock,
            $this->createMock(ValidatorAdditionInterface::class),
        );

        $request = new RegistrationKeyMakerRequest();
        $request->setRegistrationId('b46bbdcb-8714-4ed3-ab78-d5b029647213');

        self::expectException(NotFoundException::class);
        self::expectExceptionMessage('Registration data not found.');

        $useCase->execute($request);
    }

    public function testExecuteWhenKeyMakerNotFound(): void
    {
        $validatorMock = $this->createMock(RegistrationKeyMakerRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $keyMakerAdditionMock = $this->createMock(KeyMakerAdditionInterface::class);
        $keyMakerAdditionMock->expects(self::once())
            ->method('findKeyMakerOfRegistrationOrNotFound')
            ->willReturnCallback(
                function () {
                    throw new NotFoundException('Registration data not found.'); // <---
                },
            );

        $useCase = new RegistrationKeyMakerUseCase(
            $validatorMock,
            $this->createMock(RegistrationKeyMakerResponseAssemblerInterface::class),
            $keyMakerAdditionMock,
            $this->createMock(RegistrationAdditionInterface::class),
            $this->createMock(ValidatorAdditionInterface::class),
        );

        $request = new RegistrationKeyMakerRequest();
        $request->setRegistrationId('b46bbdcb-8714-4ed3-ab78-d5b029647213');

        self::expectException(NotFoundException::class);
        self::expectExceptionMessage('Registration data not found.');

        $useCase->execute($request);
    }

    public function testExecuteSuccessfully(): void
    {
        $validatorMock = $this->createMock(RegistrationKeyMakerRequestValidatorInterface::class);
        $validatorMock->expects(self::once())
            ->method('validate')
            ->willReturn(new ErrorList());

        $responseAssemblerMock = $this->createMock(RegistrationKeyMakerResponseAssemblerInterface::class);
        $responseAssemblerMock->expects(self::once())
            ->method('assemble')
            ->willReturn($this->createMock(RegistrationKeyMakerResponse::class));

        $keyMakerAdditionMock = $this->createMock(KeyMakerAdditionInterface::class);
        $keyMakerAdditionMock->expects(self::once())
            ->method('findKeyMakerOfRegistrationOrNotFound')
            ->willReturn($this->createMock(RegistrationKeyMaker::class));

        $validatorAdditionMock = $this->createMock(ValidatorAdditionInterface::class);
        $validatorAdditionMock->expects(self::once())->method('isEmptyErrorListOrUnprocessableEntity');

        $useCase = new RegistrationKeyMakerUseCase(
            $validatorMock,
            $responseAssemblerMock,
            $keyMakerAdditionMock,
            $this->createMock(RegistrationAdditionInterface::class), // TODO
            $validatorAdditionMock,
        );

        $request = new RegistrationKeyMakerRequest();
        $request->setRegistrationId('b46bbdcb-8714-4ed3-ab78-d5b029647213');

        $useCase->execute($request);
    }
}
