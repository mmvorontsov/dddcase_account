<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ServiceRoleEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\CredentialAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Security\Client;

/**
 * Class UserCredentialUseCase
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 */
final class UserCredentialUseCase implements UserCredentialUseCaseInterface
{
    /**
     * @var UserCredentialRequestValidatorInterface
     */
    private UserCredentialRequestValidatorInterface $validator;

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
     * UserCredentialUseCase constructor.
     * @param UserCredentialRequestValidatorInterface $validator
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param CredentialAdditionInterface $credentialAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UserCredentialRequestValidatorInterface $validator,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        CredentialAdditionInterface $credentialAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->credentialAddition = $credentialAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param UserCredentialRequest $request
     * @return UserCredentialResponse
     */
    public function execute(UserCredentialRequest $request): UserCredentialResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CREDENTIAL_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $this->userAddition->repositoryContainsIdOrNotFound($userId);

        if (!$this->checkAccessRightsTo($userId)) {
            throw new ForbiddenException();
        }

        $credential = $this->credentialAddition->findCredentialOfUserOrNotFound($userId);

        return new UserCredentialResponse($credential);
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
