<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery\Request\{
    CreateCredentialRecoveryByEmailRequest,
    CreateCredentialRecoveryByPhoneRequest,
};
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;
use App\Context\Account\Domain\Service\CreateCredentialRecovery\CreateCredentialRecoveryCommand;
use App\Context\Account\Domain\Service\CreateCredentialRecovery\CreateCredentialRecoveryServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use InvalidArgumentException;

use function sprintf;

/**
 * Class CreateCredentialRecoveryUseCase
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
final class CreateCredentialRecoveryUseCase implements CreateCredentialRecoveryUseCaseInterface
{
    /**
     * @var CreateCredentialRecoveryRequestValidatorInterface
     */
    private CreateCredentialRecoveryRequestValidatorInterface $validator;

    /**
     * @var CreateCredentialRecoveryServiceInterface
     */
    private CreateCredentialRecoveryServiceInterface $createCredentialRecoveryService;

    /**
     * @var CreateCredentialRecoveryResponseAssemblerInterface
     */
    private CreateCredentialRecoveryResponseAssemblerInterface $responseAssembler;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CreateCredentialRecoveryUseCase constructor.
     * @param CreateCredentialRecoveryRequestValidatorInterface $validator
     * @param CreateCredentialRecoveryServiceInterface $createCredentialRecoveryService
     * @param CreateCredentialRecoveryResponseAssemblerInterface $responseAssembler
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CreateCredentialRecoveryRequestValidatorInterface $validator,
        CreateCredentialRecoveryServiceInterface $createCredentialRecoveryService,
        CreateCredentialRecoveryResponseAssemblerInterface $responseAssembler,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->createCredentialRecoveryService = $createCredentialRecoveryService;
        $this->responseAssembler = $responseAssembler;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CreateCredentialRecoveryRequest $request
     * @return CreateCredentialRecoveryResponse
     */
    public function execute(CreateCredentialRecoveryRequest $request): CreateCredentialRecoveryResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));
        $primaryContactData = $this->createPrimaryContactData($request);

        /** @var CredentialRecovery $credentialRecovery */
        $credentialRecovery = $this->transactionalSession->executeAtomically(
            function () use ($primaryContactData) {
                return $this->createCredentialRecoveryService->execute(
                    new CreateCredentialRecoveryCommand($primaryContactData),
                );
            },
        );

        return $this->responseAssembler->assemble($credentialRecovery);
    }

    /**
     * @param CreateCredentialRecoveryRequest $request
     * @return PrimaryContactData
     */
    private function createPrimaryContactData(CreateCredentialRecoveryRequest $request): PrimaryContactData
    {
        return match (true) {
            $request instanceof CreateCredentialRecoveryByEmailRequest => EmailAddress::createFrom(
                $request->getByEmail(),
            ),
            $request instanceof CreateCredentialRecoveryByPhoneRequest => PhoneNumber::createFrom(
                $request->getByPhone(),
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unexpected request type %s.', $request::class),
            ),
        };
    }
}
