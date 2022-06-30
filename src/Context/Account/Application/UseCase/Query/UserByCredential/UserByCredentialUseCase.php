<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\CredentialAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Infrastructure\Security\Hasher\PasswordHasherInterface;

/**
 * Class UserByCredentialUseCase
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
final class UserByCredentialUseCase implements UserByCredentialUseCaseInterface
{
    /**
     * @var UserByCredentialRequestValidatorInterface
     */
    private UserByCredentialRequestValidatorInterface $validator;

    /**
     * @var UserByCredentialQueryServiceInterface
     */
    private UserByCredentialQueryServiceInterface $queryService;

    /**
     * @var PasswordHasherInterface
     */
    private PasswordHasherInterface $passwordHasher;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var CredentialAdditionInterface
     */
    private CredentialAdditionInterface $credentialAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * UserByCredentialUseCase constructor.
     * @param UserByCredentialRequestValidatorInterface $validator
     * @param UserByCredentialQueryServiceInterface $queryService
     * @param PasswordHasherInterface $passwordHasher
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param CredentialAdditionInterface $credentialAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        UserByCredentialRequestValidatorInterface $validator,
        UserByCredentialQueryServiceInterface $queryService,
        PasswordHasherInterface $passwordHasher,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        CredentialAdditionInterface $credentialAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->queryService = $queryService;
        $this->passwordHasher = $passwordHasher;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->credentialAddition = $credentialAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param UserByCredentialRequest $request
     * @return UserByCredentialResponse
     */
    public function execute(UserByCredentialRequest $request): UserByCredentialResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__USER_READ_BY_CREDENTIAL];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $user = $this->queryService->findUser($request);
        if (null === $user) {
            throw new NotFoundException('User not found.');
        }

        $credential = $this->credentialAddition
            ->findCredentialOfUserOrNotFound($user->getUserId(), 'User not found.');

        if (!$this->passwordHasher->verify($credential->getHashedPassword(), $request->getPassword())) {
            throw new NotFoundException('User not found.');
        }

        return new UserByCredentialResponse($user);
    }
}
