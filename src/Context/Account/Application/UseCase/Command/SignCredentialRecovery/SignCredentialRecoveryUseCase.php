<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Application\UseCase\Addition\CredentialRecoveryAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCodeId;
use App\Context\Account\Domain\Model\KeyMaker\WrongSecretCodeException;
use App\Context\Account\Domain\Service\SignCredentialRecovery\SignCredentialRecoveryCommand;
use App\Context\Account\Domain\Service\SignCredentialRecovery\SignCredentialRecoveryServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class SignCredentialRecoveryUseCase
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
final class SignCredentialRecoveryUseCase implements SignCredentialRecoveryUseCaseInterface
{
    /**
     * @var SignCredentialRecoveryRequestValidatorInterface
     */
    private SignCredentialRecoveryRequestValidatorInterface $validator;

    /**
     * @var SignCredentialRecoveryServiceInterface
     */
    private SignCredentialRecoveryServiceInterface $signCredentialRecoveryService;

    /**
     * @var SignCredentialRecoveryResponseAssemblerInterface
     */
    private SignCredentialRecoveryResponseAssemblerInterface $responseAssembler;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var CredentialRecoveryAdditionInterface
     */
    private CredentialRecoveryAdditionInterface $credentialRecoveryAddition;

    /**
     * @var KeyMakerAdditionInterface
     */
    private KeyMakerAdditionInterface $keyMakerAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * SignCredentialRecoveryUseCase constructor.
     * @param SignCredentialRecoveryRequestValidatorInterface $validator
     * @param SignCredentialRecoveryServiceInterface $signCredentialRecoveryService
     * @param SignCredentialRecoveryResponseAssemblerInterface $responseAssembler
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param CredentialRecoveryAdditionInterface $credentialRecoveryAddition
     * @param KeyMakerAdditionInterface $keyMakerAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        SignCredentialRecoveryRequestValidatorInterface $validator,
        SignCredentialRecoveryServiceInterface $signCredentialRecoveryService,
        SignCredentialRecoveryResponseAssemblerInterface $responseAssembler,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        CredentialRecoveryAdditionInterface $credentialRecoveryAddition,
        KeyMakerAdditionInterface $keyMakerAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->signCredentialRecoveryService = $signCredentialRecoveryService;
        $this->responseAssembler = $responseAssembler;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->credentialRecoveryAddition = $credentialRecoveryAddition;
        $this->keyMakerAddition = $keyMakerAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param SignCredentialRecoveryRequest $request
     * @return SignCredentialRecoveryResponse
     */
    public function execute(SignCredentialRecoveryRequest $request): SignCredentialRecoveryResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $credentialRecoveryId = CredentialRecoveryId::createFrom($request->getCredentialRecoveryId());
        $credentialRecovery = $this->credentialRecoveryAddition->findByIdOrNotFound($credentialRecoveryId);
        $secretCode = $request->getSecretCode();

        try {
            $this->transactionalSession->executeAtomically(
                function () use ($credentialRecovery, $secretCode) {
                    return $this->signCredentialRecoveryService->execute(
                        new SignCredentialRecoveryCommand($credentialRecovery, $secretCode),
                    );
                },
            );
        } catch (WrongSecretCodeException $e) {
            $this->registerAttempt($credentialRecoveryId, $e->getSecretCodeUuid());
            throw $e;
        }

        return $this->responseAssembler->assemble($credentialRecovery);
    }

    /**
     * @param CredentialRecoveryId $credentialRecoveryId
     * @param Uuid $secretCodeUuid
     */
    private function registerAttempt(CredentialRecoveryId $credentialRecoveryId, Uuid $secretCodeUuid): void
    {
        $keyMaker = $this->keyMakerAddition->findKeyMakerOfCredentialRecoveryOrNotFound($credentialRecoveryId);
        $this->transactionalSession->executeAtomically(
            function () use ($keyMaker, $secretCodeUuid) {
                $keyMaker->registerWrongCodeAcceptanceAttempt($secretCodeUuid);
            },
        );
    }
}
