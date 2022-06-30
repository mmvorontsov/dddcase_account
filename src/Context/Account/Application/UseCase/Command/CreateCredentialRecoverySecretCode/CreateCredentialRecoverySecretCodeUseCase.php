<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode\{
    CreateCredentialRecoverySecretCodeRequest as UseCaseRequest,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class CreateCredentialRecoverySecretCodeUseCase
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
final class CreateCredentialRecoverySecretCodeUseCase implements CreateCredentialRecoverySecretCodeUseCaseInterface
{
    /**
     * @var CreateCredentialRecoverySecretCodeRequestValidatorInterface
     */
    private CreateCredentialRecoverySecretCodeRequestValidatorInterface $validator;

    /**
     * @var CreateCredentialRecoverySecretCodeResponseAssemblerInterface
     */
    private CreateCredentialRecoverySecretCodeResponseAssemblerInterface $responseAssembler;

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
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CreateCredentialRecoverySecretCodeUseCase constructor.
     * @param CreateCredentialRecoverySecretCodeRequestValidatorInterface $validator
     * @param CreateCredentialRecoverySecretCodeResponseAssemblerInterface $responseAssembler
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param KeyMakerAdditionInterface $keyMakerAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CreateCredentialRecoverySecretCodeRequestValidatorInterface $validator,
        CreateCredentialRecoverySecretCodeResponseAssemblerInterface $responseAssembler,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        KeyMakerAdditionInterface $keyMakerAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->responseAssembler = $responseAssembler;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->keyMakerAddition = $keyMakerAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CreateCredentialRecoverySecretCodeRequest $request
     * @return CreateCredentialRecoverySecretCodeResponse
     */
    public function execute(UseCaseRequest $request): CreateCredentialRecoverySecretCodeResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        /** @var CredentialRecoveryKeyMaker|null $keyMaker */
        $keyMaker = $this->keyMakerAddition->findKeyMakerOfCredentialRecoveryOrNotFound(
            CredentialRecoveryId::createFrom($request->getCredentialRecoveryId()),
            'Credential recovery data not found.',
        );

        /** @var SecretCode $secretCode */
        $secretCode = $this->transactionalSession->executeAtomically(
            function () use ($keyMaker) {
                $keyMaker->createSecretCode();
                return $keyMaker->getLastSecretCode();
            },
        );

        return $this->responseAssembler->assemble($secretCode);
    }
}
