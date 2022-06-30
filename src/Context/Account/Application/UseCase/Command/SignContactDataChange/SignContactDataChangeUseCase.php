<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ContactDataChangeAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\BadRequestException;
use App\Context\Account\Domain\Common\Enum\PrimaryContactDataTypeEnum;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\ContactDataChange\EmailChange;
use App\Context\Account\Domain\Model\ContactDataChange\PhoneChange;
use App\Context\Account\Domain\Model\KeyMaker\WrongSecretCodeException;
use App\Context\Account\Domain\Service\SignContactDataChange\SignContactDataChangeCommand;
use App\Context\Account\Domain\Service\SignContactDataChange\SignContactDataChangeServiceInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Persistence\UniqueConstraintViolationException;
use InvalidArgumentException;

use function sprintf;
use function strtolower;
use function ucfirst;

/**
 * Class SignContactDataChangeUseCase
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 */
final class SignContactDataChangeUseCase implements SignContactDataChangeUseCaseInterface
{
    /**
     * @var SignContactDataChangeRequestValidatorInterface
     */
    private SignContactDataChangeRequestValidatorInterface $validator;

    /**
     * @var SignContactDataChangeServiceInterface
     */
    private SignContactDataChangeServiceInterface $signContactDataChangeService;

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
     * @var SecurityAdditionInterface
     */
    private SecurityAdditionInterface $securityAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * SignContactDataChangeUseCase constructor.
     * @param SignContactDataChangeRequestValidatorInterface $validator
     * @param SignContactDataChangeServiceInterface $signContactDataChangeService
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param ContactDataChangeAdditionInterface $contactDataChangeAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        SignContactDataChangeRequestValidatorInterface $validator,
        SignContactDataChangeServiceInterface $signContactDataChangeService,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        ContactDataChangeAdditionInterface $contactDataChangeAddition,
        SecurityAdditionInterface $securityAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->signContactDataChangeService = $signContactDataChangeService;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->contactDataChangeAddition = $contactDataChangeAddition;
        $this->securityAddition = $securityAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param SignContactDataChangeRequest $request
     * @return SignContactDataChangeResponse
     */
    public function execute(SignContactDataChangeRequest $request): SignContactDataChangeResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_SIGN];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $contactDataChangeId = ContactDataChangeId::createFrom($request->getContactDataChangeId());
        $contactDataChange = $this->contactDataChangeAddition->findByIdOrNotFound($contactDataChangeId);
        $this->securityAddition->isAuthenticatedUserIdOrForbidden($contactDataChange->getUserId());

        $secretCode = $request->getSecretCode();

        try {
            $this->transactionalSession->executeAtomically(
                function () use ($contactDataChange, $secretCode) {
                    return $this->signContactDataChangeService->execute(
                        new SignContactDataChangeCommand($contactDataChange, $secretCode),
                    );
                },
            );
        } catch (WrongSecretCodeException $e) {
            $keyMaker = $e->getKeyMaker();
            $secretCodeId = $e->getSecretCodeId();
            $this->transactionalSession->executeAtomically(
                function () use ($keyMaker, $secretCodeId) {
                    $keyMaker->registerWrongCodeAcceptanceAttemptFor($secretCodeId);
                },
            );
            throw $e;
        } catch (UniqueConstraintViolationException) {
            $type = ucfirst(strtolower($this->getContactDataChangeType($contactDataChange)));
            $value = $contactDataChange->getToValue()->getValue();
            throw new BadRequestException(sprintf('%s %s is already in use.', $type, $value));
        }

        return new SignContactDataChangeResponse($contactDataChange);
    }

    /**
     * @param ContactDataChange $contactDataChange
     * @return string
     */
    private function getContactDataChangeType(ContactDataChange $contactDataChange): string
    {
        return match (true) {
            $contactDataChange instanceof EmailChange => PrimaryContactDataTypeEnum::EMAIL,
            $contactDataChange instanceof PhoneChange => PrimaryContactDataTypeEnum::PHONE,
            default => throw new InvalidArgumentException(
                sprintf('Unexpected contact data change type %s.', $contactDataChange::class),
            ),
        };
    }
}
