<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use App\Context\Account\Application\Security\AccessControl\Permission\UserPermissionEnum;
use App\Context\Account\Application\UseCase\Addition\AuthorizationCheckerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\SecurityAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Application\UseCase\NotFoundException;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class ContactDataChangeKeyMakerUseCase
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
final class ContactDataChangeKeyMakerUseCase implements ContactDataChangeKeyMakerUseCaseInterface
{
    /**
     * @var ContactDataChangeKeyMakerRequestValidatorInterface
     */
    private ContactDataChangeKeyMakerRequestValidatorInterface $validator;

    /**
     * @var ContactDataChangeKeyMakerQueryServiceInterface
     */
    private ContactDataChangeKeyMakerQueryServiceInterface $queryService;

    /**
     * @var AuthorizationCheckerAdditionInterface
     */
    private AuthorizationCheckerAdditionInterface $authorizationCheckerAddition;

    /**
     * @var SecurityAdditionInterface
     */
    private SecurityAdditionInterface $securityAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * ContactDataChangeKeyMakerUseCase constructor.
     * @param ContactDataChangeKeyMakerRequestValidatorInterface $validator
     * @param ContactDataChangeKeyMakerQueryServiceInterface $queryService
     * @param AuthorizationCheckerAdditionInterface $authorizationCheckerAddition
     * @param SecurityAdditionInterface $securityAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        ContactDataChangeKeyMakerRequestValidatorInterface $validator,
        ContactDataChangeKeyMakerQueryServiceInterface $queryService,
        AuthorizationCheckerAdditionInterface $authorizationCheckerAddition,
        SecurityAdditionInterface $securityAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->queryService = $queryService;
        $this->authorizationCheckerAddition = $authorizationCheckerAddition;
        $this->securityAddition = $securityAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param ContactDataChangeKeyMakerRequest $request
     * @return ContactDataChangeKeyMakerResponse
     */
    public function execute(ContactDataChangeKeyMakerRequest $request): ContactDataChangeKeyMakerResponse
    {
        $requiredPermissions = [UserPermissionEnum::PERMISSION__DDDCASE_ACCOUNT__CONTACT_DATA_CHANGE_KEY_MAKER_READ];
        $this->authorizationCheckerAddition->canOrForbidden($requiredPermissions);
        $client = $this->securityAddition->getAuthenticatedUserOrForbidden();
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $userId = UserId::createFrom($client->getId());
        $keyMaker = $this->queryService->findKeyMaker($request, $userId);

        if (null === $keyMaker) {
            throw new NotFoundException('Contact data change not found.');
        }

        return new ContactDataChangeKeyMakerResponse($keyMaker);
    }
}
