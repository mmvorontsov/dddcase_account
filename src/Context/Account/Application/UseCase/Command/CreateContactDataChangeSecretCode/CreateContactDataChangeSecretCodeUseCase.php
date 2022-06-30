<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ContactDataChangeAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAddition;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode\{
    CreateContactDataChangeSecretCodeRequest as UseCaseRequest,
    CreateContactDataChangeSecretCodeResponse as UseCaseResponse,
};
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;
use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class CreateRegistrationSecretCodeUseCase
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
final class CreateContactDataChangeSecretCodeUseCase implements CreateContactDataChangeSecretCodeUseCaseInterface
{
    /**
     * @var CreateContactDataChangeSecretCodeRequestValidatorInterface
     */
    private CreateContactDataChangeSecretCodeRequestValidatorInterface $validator;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var ContactDataChangeAdditionInterface
     */
    private ContactDataChangeAdditionInterface $contactDataChangeAddition;

    /**
     * @var KeyMakerAdditionInterface
     */
    private KeyMakerAdditionInterface $keyMakerAddition;

    /**
     * @var SecurityAdditionInterface
     */
    private SecurityAdditionInterface $securityAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CreateContactDataChangeSecretCodeUseCase constructor.
     * @param CreateContactDataChangeSecretCodeRequestValidatorInterface $validator
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param ContactDataChangeAdditionInterface $contactDataChangeAddition
     * @param KeyMakerAdditionInterface $keyMakerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CreateContactDataChangeSecretCodeRequestValidatorInterface $validator,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        ContactDataChangeAdditionInterface $contactDataChangeAddition,
        KeyMakerAdditionInterface $keyMakerAddition,
        SecurityAdditionInterface $securityAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->contactDataChangeAddition = $contactDataChangeAddition;
        $this->keyMakerAddition = $keyMakerAddition;
        $this->securityAddition = $securityAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CreateContactDataChangeSecretCodeRequest $request
     * @return CreateContactDataChangeSecretCodeResponse
     */
    public function execute(UseCaseRequest $request): UseCaseResponse
    {
        $permissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_SECRET_CODE_CREATE];
        $this->authorizationCheckerAddition->canOrForbidden($permissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $contactDataChangeId = ContactDataChangeId::createFrom($request->getContactDataChangeId());
        $contactDataChange = $this->contactDataChangeAddition->findByIdOrNotFound($contactDataChangeId);
        $this->securityAddition->isAuthenticatedUserIdOrForbidden($contactDataChange->getUserId());

        /** @var ContactDataChangeKeyMaker|null $keyMaker */
        $keyMaker = $this->keyMakerAddition->findKeyMakerOfContactDataChangeOrNotFound(
            ContactDataChangeId::createFrom($request->getContactDataChangeId()),
            'Contact data change not found.',
        );

        /** @var SecretCode $secretCode */
        $secretCode = $this->transactionalSession->executeAtomically(
            function () use ($keyMaker) {
                $keyMaker->createSecretCode();
                return $keyMaker->getSecretCodes()->last();
            },
        );

        return new CreateContactDataChangeSecretCodeResponse($secretCode);
    }
}
