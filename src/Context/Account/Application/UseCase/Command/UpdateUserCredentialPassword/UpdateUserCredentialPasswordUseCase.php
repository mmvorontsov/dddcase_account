<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\CredentialAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\BadRequestException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Credential\Update\UpdateCredentialCommand;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;

/**
 * Class UpdateUserCredentialPasswordUseCase
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 */
final class UpdateUserCredentialPasswordUseCase implements UpdateUserCredentialPasswordUseCaseInterface
{
    /**
     * @var UpdateUserCredentialPasswordRequestValidatorInterface
     */
    private UpdateUserCredentialPasswordRequestValidatorInterface $validator;

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
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var CredentialAdditionInterface
     */
    private CredentialAdditionInterface $credentialAddition;

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
     * UpdateUserCredentialPasswordUseCase constructor.
     * @param UpdateUserCredentialPasswordRequestValidatorInterface $validator
     * @param PasswordHasherInterface $passwordHasher
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param CredentialAdditionInterface $credentialAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UpdateUserCredentialPasswordRequestValidatorInterface $validator,
        PasswordHasherInterface $passwordHasher,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        CredentialAdditionInterface $credentialAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->passwordHasher = $passwordHasher;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->credentialAddition = $credentialAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param UpdateUserCredentialPasswordRequest $request
     * @return UpdateUserCredentialPasswordResponse
     */
    public function execute(UpdateUserCredentialPasswordRequest $request): UpdateUserCredentialPasswordResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_PASSWORD_UPDATE];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $this->userAddition->repositoryContainsIdOrNotFound($userId);
        $this->securityAddition->isAuthenticatedUserIdOrForbidden($userId);

        $credential = $this->credentialAddition->findCredentialOfUserOrNotFound($userId);

        if (!$this->passwordHasher->verify($credential->getHashedPassword(), $request->getCurrentPassword())) {
            throw new BadRequestException('Current password is invalid.');
        }

        $updateCredentialPasswordCommand = new UpdateCredentialCommand();
        $updateCredentialPasswordCommand->setHashedPassword(
            $this->passwordHasher->hash($request->getPassword()),
        );

        $this->transactionalSession->executeAtomically(
            function () use ($credential, $updateCredentialPasswordCommand) {
                $credential->update($updateCredentialPasswordCommand);
                return $credential;
            },
        );

        return new UpdateUserCredentialPasswordResponse($credential);
    }
}
