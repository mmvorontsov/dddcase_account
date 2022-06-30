<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\RoleAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Model\Role\RoleId;
use Exception;

/**
 * Class RoleUseCase
 * @package App\Context\Account\Application\UseCase\Query\Role
 */
final class RoleUseCase implements RoleUseCaseInterface
{
    /**
     * @var RoleRequestValidatorInterface
     */
    private RoleRequestValidatorInterface $validator;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var RoleAdditionInterface
     */
    private RoleAdditionInterface $roleAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * RoleUseCase constructor.
     * @param RoleRequestValidatorInterface $validator
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param RoleAdditionInterface $roleAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        RoleRequestValidatorInterface $validator,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        RoleAdditionInterface $roleAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->roleAddition = $roleAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param RoleRequest $request
     * @return RoleResponse
     * @throws Exception
     */
    public function execute(RoleRequest $request): RoleResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__ROLE_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $role = $this->roleAddition->findByIdOrNotFound(RoleId::createFrom($request->getRoleId()));

        return new RoleResponse($role);
    }
}
