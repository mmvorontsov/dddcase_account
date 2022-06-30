<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\UseCase\Addition\RegistrationAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\BadRequestException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerId;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCodeId;
use App\Context\Account\Domain\Model\KeyMaker\WrongSecretCodeException;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Service\SignRegistration\SignRegistrationCommand;
use App\Context\Account\Domain\Service\SignRegistration\SignRegistrationServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Persistence\UniqueConstraintViolationException;

use function sprintf;

/**
 * Class SignRegistrationUseCase
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
class SignRegistrationUseCase implements SignRegistrationUseCaseInterface
{
    /**
     * @var SignRegistrationRequestValidatorInterface
     */
    private SignRegistrationRequestValidatorInterface $validator;

    /**
     * @var SignRegistrationServiceInterface
     */
    private SignRegistrationServiceInterface $signRegistrationService;

    /**
     * @var KeyMakerRepositoryInterface
     */
    private KeyMakerRepositoryInterface $keyMakerRepository;

    /**
     * @var SignRegistrationResponseAssemblerInterface
     */
    private SignRegistrationResponseAssemblerInterface $responseAssembler;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var RegistrationAdditionInterface
     */
    private RegistrationAdditionInterface $registrationAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * SignRegistrationUseCase constructor.
     * @param SignRegistrationRequestValidatorInterface $validator
     * @param SignRegistrationServiceInterface $signRegistrationService
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param SignRegistrationResponseAssemblerInterface $responseAssembler
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param RegistrationAdditionInterface $registrationAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        SignRegistrationRequestValidatorInterface $validator,
        SignRegistrationServiceInterface $signRegistrationService,
        KeyMakerRepositoryInterface $keyMakerRepository,
        SignRegistrationResponseAssemblerInterface $responseAssembler,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        RegistrationAdditionInterface $registrationAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->signRegistrationService = $signRegistrationService;
        $this->keyMakerRepository = $keyMakerRepository;
        $this->responseAssembler = $responseAssembler;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->registrationAddition = $registrationAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param SignRegistrationRequest $request
     * @return SignRegistrationResponse
     */
    public function execute(SignRegistrationRequest $request): SignRegistrationResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $registrationId = RegistrationId::createFrom($request->getRegistrationId());
        $registration = $this->registrationAddition->findByIdOrNotFound($registrationId);

        $secretCode = $request->getSecretCode();
        $roleIds = [RoleId::createFrom(ProtectedUserRoleEnum::ROLE_PROTECTED__USER__BASE)];

        try {
            $this->transactionalSession->executeAtomically(
                function () use ($registration, $secretCode, $roleIds) {
                    return $this->signRegistrationService->execute(
                        new SignRegistrationCommand($registration, $secretCode, $roleIds),
                    );
                },
            );
        } catch (WrongSecretCodeException $e) {
            $this->registerWrongCodeAcceptanceAttempt($e->getKeyMakerId(), $e->getSecretCodeId());
            throw $e;
        } catch (UniqueConstraintViolationException) {
            $email = $registration->getPersonalData()->getEmail();
            throw new BadRequestException(
                sprintf('Email %s is already in use.', $email->getValue()),
            );
        }

        return $this->responseAssembler->assemble($registration);
    }

    /**
     * @param KeyMakerId $keyMakerId
     * @param SecretCodeId $secretCodeId
     */
    private function registerWrongCodeAcceptanceAttempt(KeyMakerId $keyMakerId, SecretCodeId $secretCodeId): void
    {
        $keyMaker = $this->keyMakerRepository->findById($keyMakerId);
        $this->transactionalSession->executeAtomically(
            function () use ($keyMaker, $secretCodeId) {
                $keyMaker->registerWrongCodeAcceptanceAttempt($secretCodeId);
            },
        );
    }
}
