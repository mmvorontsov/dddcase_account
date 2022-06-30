<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;

/**
 * Class UsersUseCase
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
final class UsersUseCase implements UsersUseCaseInterface
{
    /**
     * @var UsersRequestValidatorInterface
     */
    private UsersRequestValidatorInterface $validator;

    /**
     * @var UsersQueryServiceInterface
     */
    private UsersQueryServiceInterface $queryService;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * UsersUseCase constructor.
     * @param UsersRequestValidatorInterface $validator
     * @param UsersQueryServiceInterface $queryService
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UsersRequestValidatorInterface $validator,
        UsersQueryServiceInterface $queryService,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->queryService = $queryService;
        $this->validator = $validator;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param UsersRequest $request
     * @return UsersResponse
     */
    public function execute(UsersRequest $request): UsersResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USERS_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $users = $this->queryService->findUsers($request);

        return new UsersResponse($users);
    }
}
