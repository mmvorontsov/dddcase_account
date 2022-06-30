<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Security\Client;

/**
 * Class UserPermissionsUseCase
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 */
final class UserPermissionsUseCase implements UserPermissionsUseCaseInterface
{
    /**
     * @var UserPermissionsRequestValidatorInterface
     */
    private UserPermissionsRequestValidatorInterface $validator;

    /**
     * @var UserPermissionsQueryServiceInterface
     */
    private UserPermissionsQueryServiceInterface $queryService;

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
     * UserPermissionsUseCase constructor.
     * @param UserPermissionsRequestValidatorInterface $validator
     * @param UserPermissionsQueryServiceInterface $queryService
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UserPermissionsRequestValidatorInterface $validator,
        UserPermissionsQueryServiceInterface $queryService,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->queryService = $queryService;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param UserPermissionsRequest $request
     * @return UserPermissionsResponse
     */
    public function execute(UserPermissionsRequest $request): UserPermissionsResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_PERMISSIONS_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $this->userAddition->repositoryContainsIdOrNotFound($userId);

        if (!$this->checkAccessRightsTo($userId)) {
            throw new ForbiddenException();
        }

        $permissions = $this->queryService->findPermissions($request);

        return new UserPermissionsResponse($permissions);
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
            ],
        );
    }
}
