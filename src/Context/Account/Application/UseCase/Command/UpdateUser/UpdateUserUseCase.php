<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\User\Update\UpdateUserCommand;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use App\Context\Account\Infrastructure\Security\Client;

/**
 * Class UpdateUserUseCase
 * @package App\Context\Account\Application\UseCase\Command\UpdateUser
 */
final class UpdateUserUseCase implements UpdateUserUseCaseInterface
{
    /**
     * @var UpdateUserRequestValidatorInterface
     */
    private UpdateUserRequestValidatorInterface $validator;

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
     * UpdateUserUseCase constructor.
     * @param UpdateUserRequestValidatorInterface $validator
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UpdateUserRequestValidatorInterface $validator,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param UpdateUserRequest $request
     * @return UpdateUserResponse
     */
    public function execute(UpdateUserRequest $request): UpdateUserResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_UPDATE];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $user = $this->userAddition->findByIdOrNotFound($userId);

        if (!$this->checkAccessRightsTo($user->getUserId())) {
            throw new ForbiddenException();
        }

        $updateUserCommand = $this->createUpdateUserCommand($request);
        $this->transactionalSession->executeAtomically(
            function () use ($user, $updateUserCommand) {
                $user->update($updateUserCommand);
                return $user;
            },
        );

        return new UpdateUserResponse($user);
    }

    /**
     * @param UserId $userId
     * @return bool
     */
    private function checkAccessRightsTo(UserId $userId): bool
    {
        $client = $this->securityAddition->getClient();

        // Access to myself is allowed
        if ($client instanceof Client\User && $userId->getValue() === $client->getId()) {
            return true;
        }

        // Almighty roles of this action (at least one)
        return $this->authorizationCheckerAddition->beOr(
            [
                // Protected roles
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                // Context roles
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
            ],
        );
    }

    /**
     * @param UpdateUserRequest $request
     * @return UpdateUserCommand
     */
    private function createUpdateUserCommand(UpdateUserRequest $request): UpdateUserCommand
    {
        $updateUserCommand = new UpdateUserCommand();
        if (null !== $request->getFirstname()) {
            $updateUserCommand->setFirstname($request->getFirstname());
        }

        return $updateUserCommand;
    }
}
