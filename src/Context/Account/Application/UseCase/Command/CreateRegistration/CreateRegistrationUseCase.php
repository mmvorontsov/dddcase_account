<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Registration\CreateRegistrationCommand;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationRepositoryInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;

/**
 * Class CreateRegistrationUseCase
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
final class CreateRegistrationUseCase implements CreateRegistrationUseCaseInterface
{
    /**
     * @var CreateRegistrationRequestValidatorInterface
     */
    private CreateRegistrationRequestValidatorInterface $validator;

    /**
     * @var RegistrationRepositoryInterface
     */
    private RegistrationRepositoryInterface $registrationRepository;

    /**
     * @var CreateRegistrationResponseAssemblerInterface
     */
    private CreateRegistrationResponseAssemblerInterface $responseAssembler;

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
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CreateRegistrationUseCase constructor.
     * @param CreateRegistrationRequestValidatorInterface $validator
     * @param RegistrationRepositoryInterface $registrationRepository
     * @param CreateRegistrationResponseAssemblerInterface $responseAssembler
     * @param PasswordHasherInterface $passwordHasher
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CreateRegistrationRequestValidatorInterface $validator,
        RegistrationRepositoryInterface $registrationRepository,
        CreateRegistrationResponseAssemblerInterface $responseAssembler,
        PasswordHasherInterface $passwordHasher,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->registrationRepository = $registrationRepository;
        $this->responseAssembler = $responseAssembler;
        $this->passwordHasher = $passwordHasher;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CreateRegistrationRequest $request
     * @return CreateRegistrationResponse
     */
    public function execute(CreateRegistrationRequest $request): CreateRegistrationResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));
        $hashedPassword = $this->passwordHasher->hash($request->getPassword());

        /** @var Registration $registration */
        $registration = $this->transactionalSession->executeAtomically(
            function () use ($request, $hashedPassword) {
                $registration = Registration::create(
                    new CreateRegistrationCommand(
                        $request->getFirstname(),
                        $hashedPassword,
                        EmailAddress::createFrom($request->getEmail()),
                    ),
                );
                $this->registrationRepository->add($registration);
                return $registration;
            }
        );

        return $this->responseAssembler->assemble($registration);
    }
}
