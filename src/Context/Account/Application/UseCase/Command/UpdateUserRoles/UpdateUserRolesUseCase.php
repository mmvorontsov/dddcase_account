<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\Update\UpdateUserCommand;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

use function array_map;

/**
 * Class UpdateUserRolesUseCase
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 */
final class UpdateUserRolesUseCase implements UpdateUserRolesUseCaseInterface
{
    /**
     * @var UpdateUserRolesRequestValidatorInterface
     */
    private UpdateUserRolesRequestValidatorInterface $validator;

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
     * @var UserAdditionInterface
     */
    private UserAdditionInterface $userAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * UpdateUserUseCase constructor.
     * @param UpdateUserRolesRequestValidatorInterface $validator
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UpdateUserRolesRequestValidatorInterface $validator,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param UpdateUserRolesRequest $request
     * @return UpdateUserRolesResponse
     */
    public function execute(UpdateUserRolesRequest $request): UpdateUserRolesResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_ROLES_UPDATE];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $user = $this->userAddition->findByIdOrNotFound($userId);
        $roleIds = array_map(
            fn(string $id) => RoleId::createFrom($id),
            $request->getRoleIds(),
        );

        $updateUserCommand = new UpdateUserCommand();
        $updateUserCommand->setRoleIds($roleIds);

        $this->transactionalSession->executeAtomically(
            function () use ($user, $request, $updateUserCommand) {
                $user->update($updateUserCommand);
                return $user;
            },
        );

        return new UpdateUserRolesResponse($user);
    }
}
