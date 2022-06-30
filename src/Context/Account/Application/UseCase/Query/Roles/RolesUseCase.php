<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;

/**
 * Class RolesUseCase
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
final class RolesUseCase implements RolesUseCaseInterface
{
    /**
     * @var RolesRequestValidatorInterface
     */
    private RolesRequestValidatorInterface $validator;

    /**
     * @var RolesQueryServiceInterface
     */
    private RolesQueryServiceInterface $queryService;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * RolesUseCase constructor.
     * @param RolesRequestValidatorInterface $validator
     * @param RolesQueryServiceInterface $queryService
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        RolesRequestValidatorInterface $validator,
        RolesQueryServiceInterface $queryService,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->queryService = $queryService;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param RolesRequest $request
     * @return RolesResponse
     */
    public function execute(RolesRequest $request): RolesResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__ROLES_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $roles = $this->queryService->findRoles($request);

        return new RolesResponse($roles);
    }
}
