<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ContactDataAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\{
    CreateContactDataChangeRequest as UseCaseRequest,
};
use App\Context\Account\Application\UseCase\Command\CreateContactDataChange\Request\{
    CreateEmailChangeRequest,
    CreatePhoneChangeRequest,
};
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeRepositoryInterface;
use App\Context\Account\Domain\Model\ContactDataChange\CreateEmailChangeCommand;
use App\Context\Account\Domain\Model\ContactDataChange\CreatePhoneChangeCommand;
use App\Context\Account\Domain\Model\ContactDataChange\EmailChange;
use App\Context\Account\Domain\Model\ContactDataChange\PhoneChange;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use Exception;
use InvalidArgumentException;

use function sprintf;

/**
 * Class CreateContactDataChangeUseCase
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
final class CreateContactDataChangeUseCase implements CreateContactDataChangeUseCaseInterface
{
    /**
     * @var CreateContactDataChangeRequestValidatorInterface
     */
    private CreateContactDataChangeRequestValidatorInterface $validator;

    /**
     * @var ContactDataChangeRepositoryInterface
     */
    private ContactDataChangeRepositoryInterface $contactDataChangeRepository;

    /**
     * @var CreateContactDataChangeResponseAssemblerInterface
     */
    private CreateContactDataChangeResponseAssemblerInterface $responseAssembler;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var ContactDataAdditionInterface
     */
    private ContactDataAdditionInterface $contactDataAddition;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var SecurityAdditionInterface
     */
    private SecurityAdditionInterface $securityAddition;

    /**
     * @var UserAdditionInterface
     */
    private UserAdditionInterface $userAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CreateContactDataChangeUseCase constructor.
     * @param CreateContactDataChangeRequestValidatorInterface $validator
     * @param ContactDataChangeRepositoryInterface $contactDataChangeRepository
     * @param CreateContactDataChangeResponseAssemblerInterface $responseAssembler
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param ContactDataAdditionInterface $contactDataAddition
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CreateContactDataChangeRequestValidatorInterface $validator,
        ContactDataChangeRepositoryInterface $contactDataChangeRepository,
        CreateContactDataChangeResponseAssemblerInterface $responseAssembler,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        ContactDataAdditionInterface $contactDataAddition,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->contactDataChangeRepository = $contactDataChangeRepository;
        $this->responseAssembler = $responseAssembler;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->contactDataAddition = $contactDataAddition;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CreateContactDataChangeRequest $request
     * @return CreateContactDataChangeResponse
     */
    public function execute(CreateContactDataChangeRequest $request): CreateContactDataChangeResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_CREATE];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $client = $this->securityAddition->getAuthenticatedUserOrForbidden();
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($client->getId());
        $this->userAddition->repositoryContainsIdOrForbidden($userId);
        $contactData = $this->contactDataAddition->findContactDataOfUserOrNotFound($userId);

        /** @var ContactDataChange $contactDataChange */
        $contactDataChange = $this->transactionalSession->executeAtomically(
            function () use ($request, $contactData) {
                $contactDataChange = $this->createContactDataChange($request, $contactData);
                $this->contactDataChangeRepository->add($contactDataChange);
                return $contactDataChange;
            },
        );

        return $this->responseAssembler->assemble($contactDataChange);
    }

    /**
     * @param CreateContactDataChangeRequest $request
     * @param ContactData $contactData
     * @return ContactDataChange
     * @throws Exception
     */
    private function createContactDataChange(UseCaseRequest $request, ContactData $contactData): ContactDataChange
    {
        return match (true) {
            $request instanceof CreateEmailChangeRequest => EmailChange::create(
                new CreateEmailChangeCommand(
                    $contactData->getUserId(),
                    $contactData->getEmail(),
                    EmailAddress::createFrom($request->getToEmail()),
                ),
            ),
            $request instanceof CreatePhoneChangeRequest => PhoneChange::create(
                new CreatePhoneChangeCommand(
                    $contactData->getUserId(),
                    $contactData->getPhone(),
                    PhoneNumber::createFrom($request->getToPhone()),
                ),
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unexpected request type %s.', $request::class),
            ),
        };
    }
}
