<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ContextUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ProtectedUserRoleEnum;
use App\Context\Account\Application\Security\AccessControl\Role\ServiceRoleEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ContactDataAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\UserAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\ForbiddenException;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Infrastructure\Security\Client;

/**
 * Class UserContactDataUseCase
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 */
final class UserContactDataUseCase implements UserContactDataUseCaseInterface
{
    /**
     * @var UserContactDataRequestValidatorInterface
     */
    private UserContactDataRequestValidatorInterface $validator;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var ContactDataAdditionInterface
     */
    private ContactDataAdditionInterface $contactDataAddition;

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
     * UserContactDataUseCase constructor.
     * @param UserContactDataRequestValidatorInterface $validator
     * @param ContactDataAdditionInterface $contactDataAddition
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param UserAdditionInterface $userAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UserContactDataRequestValidatorInterface $validator,
        ContactDataAdditionInterface $contactDataAddition,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        SecurityAdditionInterface $securityAddition,
        UserAdditionInterface $userAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->contactDataAddition = $contactDataAddition;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->securityAddition = $securityAddition;
        $this->userAddition = $userAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param UserContactDataRequest $request
     * @return UserContactDataResponse
     */
    public function execute(UserContactDataRequest $request): UserContactDataResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_CONTACT_DATA_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($request->getUserId());
        $this->userAddition->repositoryContainsIdOrNotFound($userId);

        if (!$this->checkAccessRightsTo($userId)) {
            throw new ForbiddenException();
        }

        $contactData = $this->contactDataAddition->findContactDataOfUserOrNotFound($userId);

        return new UserContactDataResponse($contactData);
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
