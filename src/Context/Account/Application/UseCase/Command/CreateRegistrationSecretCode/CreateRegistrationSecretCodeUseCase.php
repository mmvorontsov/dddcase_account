<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\RegistrationAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class CreateRegistrationSecretCodeUseCase
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
final class CreateRegistrationSecretCodeUseCase implements CreateRegistrationSecretCodeUseCaseInterface
{
    /**
     * @var CreateRegistrationSecretCodeRequestValidatorInterface
     */
    private CreateRegistrationSecretCodeRequestValidatorInterface $validator;

    /**
     * @var CreateRegistrationSecretCodeResponseAssemblerInterface
     */
    private CreateRegistrationSecretCodeResponseAssemblerInterface $responseAssembler;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var KeyMakerAdditionInterface
     */
    private KeyMakerAdditionInterface $keyMakerAddition;

    /**
     * @var RegistrationAdditionInterface
     */
    private RegistrationAdditionInterface $registrationAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CreateRegistrationSecretCodeUseCase constructor.
     * @param CreateRegistrationSecretCodeRequestValidatorInterface $validator
     * @param CreateRegistrationSecretCodeResponseAssemblerInterface $responseAssembler
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param KeyMakerAdditionInterface $keyMakerAddition
     * @param RegistrationAdditionInterface $registrationAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CreateRegistrationSecretCodeRequestValidatorInterface $validator,
        CreateRegistrationSecretCodeResponseAssemblerInterface $responseAssembler,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        KeyMakerAdditionInterface $keyMakerAddition,
        RegistrationAdditionInterface $registrationAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->responseAssembler = $responseAssembler;
        $this->keyMakerAddition = $keyMakerAddition;
        $this->registrationAddition = $registrationAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CreateRegistrationSecretCodeRequest $request
     * @return CreateRegistrationSecretCodeResponse
     */
    public function execute(CreateRegistrationSecretCodeRequest $request): CreateRegistrationSecretCodeResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));
        $registrationId = RegistrationId::createFrom($request->getRegistrationId());
        $this->registrationAddition->repositoryContainsIdOrNotFound($registrationId);

        /** @var RegistrationKeyMaker|null $keyMaker */
        $keyMaker = $this->keyMakerAddition->findKeyMakerOfRegistrationOrNotFound(
            $registrationId,
            'Registration data not found.',
        );

        /** @var SecretCode $secretCode */
        $secretCode = $this->transactionalSession->executeAtomically(
            function () use ($keyMaker) {
                $keyMaker->createSecretCode();
                return $keyMaker->getSecretCodes()->last();
            },
        );

        return $this->responseAssembler->assemble($secretCode);
    }
}
