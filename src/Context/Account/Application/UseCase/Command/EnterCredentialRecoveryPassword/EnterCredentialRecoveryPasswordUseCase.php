<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Application\UseCase\Addition\CredentialRecoveryAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword\{
    EnterCredentialRecoveryPasswordCommand,
    EnterCredentialRecoveryPasswordServiceInterface,
};
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;

/**
 * Class EnterCredentialRecoveryPasswordUseCase
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
final class EnterCredentialRecoveryPasswordUseCase implements EnterCredentialRecoveryPasswordUseCaseInterface
{
    /**
     * @var EnterCredentialRecoveryPasswordRequestValidatorInterface
     */
    private EnterCredentialRecoveryPasswordRequestValidatorInterface $validator;

    /**
     * @var EnterCredentialRecoveryPasswordServiceInterface
     */
    private EnterCredentialRecoveryPasswordServiceInterface $enterCredentialRecoveryPasswordService;

    /**
     * @var EnterCredentialRecoveryPasswordResponseAssemblerInterface
     */
    private EnterCredentialRecoveryPasswordResponseAssemblerInterface $responseAssembler;

    /**
     * @var PasswordHasherInterface
     */
    private PasswordHasherInterface $passwordHasher;

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
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * EnterCredentialRecoveryPasswordUseCase constructor.
     * @param EnterCredentialRecoveryPasswordRequestValidatorInterface $validator
     * @param EnterCredentialRecoveryPasswordServiceInterface $enterCredentialRecoveryPasswordService
     * @param EnterCredentialRecoveryPasswordResponseAssemblerInterface $responseAssembler
     * @param PasswordHasherInterface $passwordHasher
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param CredentialRecoveryAdditionInterface $credentialRecoveryAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        EnterCredentialRecoveryPasswordRequestValidatorInterface $validator,
        EnterCredentialRecoveryPasswordServiceInterface $enterCredentialRecoveryPasswordService,
        EnterCredentialRecoveryPasswordResponseAssemblerInterface $responseAssembler,
        PasswordHasherInterface $passwordHasher,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        CredentialRecoveryAdditionInterface $credentialRecoveryAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->enterCredentialRecoveryPasswordService = $enterCredentialRecoveryPasswordService;
        $this->responseAssembler = $responseAssembler;
        $this->passwordHasher = $passwordHasher;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->credentialRecoveryAddition = $credentialRecoveryAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param EnterCredentialRecoveryPasswordRequest $request
     * @return EnterCredentialRecoveryPasswordResponse
     */
    public function execute(EnterCredentialRecoveryPasswordRequest $request): EnterCredentialRecoveryPasswordResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));
        $credentialRecoveryId = CredentialRecoveryId::createFrom($request->getCredentialRecoveryId());
        $credentialRecovery = $this->credentialRecoveryAddition->findByIdOrNotFound($credentialRecoveryId);

        if ($credentialRecovery->getPasswordEntryCode() !== $request->getPasswordEntryCode()) {
            throw new NotFoundException('Credential recovery data not found.');
        }

        $command = new EnterCredentialRecoveryPasswordCommand(
            $credentialRecovery,
            $this->passwordHasher->hash($request->getPassword()),
            $request->getPasswordEntryCode(),
        );

        $this->transactionalSession->executeAtomically(
            function () use ($command) {
                return $this->enterCredentialRecoveryPasswordService->execute($command);
            },
        );

        return $this->responseAssembler->assemble($credentialRecovery);
    }
}
