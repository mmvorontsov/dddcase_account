<?php

namespace App\Context\Account\Application\UseCase\Query\User;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ServiceRoleEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Security\Client;

/**
 * Class UserUseCase
 * @package App\Context\Account\Application\UseCase\Query\User
 */
final class UserUseCase implements UserUseCaseInterface
{
    /**
     * @var UserRequestValidatorInterface
     */
    private UserRequestValidatorInterface $validator;

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
     * UserUseCase constructor.
     * @param UserRequestValidatorInterface $validator
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UserRequestValidatorInterface $validator,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param UserRequest $request
     * @return UserResponse
     */
    public function execute(UserRequest $request): UserResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $user = $this->userAddition->findByIdOrNotFound($userId);

        if (!$this->checkAccessRightsTo($userId)) {
            throw new ForbiddenException();
        }

        return new UserResponse($user);
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

        // Access for the following roles is justified
        return $this->authorizationCheckerAddition->beOr(
            [
                // Protected roles
                ProtectedUserRoleEnum::ROLE_PROTECTED__USER__SUPER,
                // Context roles
                ContextUserRoleEnum::ROLE__USER__DDDCASE_ACCOUNT__ADMIN,
                // Service roles
                ServiceRoleEnum::ROLE__SERVICE__BASE,
            ],
        );
    }
}
