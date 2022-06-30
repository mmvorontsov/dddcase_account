<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\RegistrationAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;
use App\Context\Account\Domain\Model\Registration\RegistrationId;

/**
 * Class RegistrationKeyMakerUseCase
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
final class RegistrationKeyMakerUseCase implements RegistrationKeyMakerUseCaseInterface
{
    /**
     * @var RegistrationKeyMakerRequestValidatorInterface
     */
    private RegistrationKeyMakerRequestValidatorInterface $validator;

    /**
     * @var RegistrationKeyMakerResponseAssemblerInterface
     */
    public RegistrationKeyMakerResponseAssemblerInterface $responseAssembler;

    /**
     * @var KeyMakerAdditionInterface
     */
    private KeyMakerAdditionInterface $keyMakerAddition;

    /**
     * @var RegistrationAdditionInterface
     */
    private RegistrationAdditionInterface $registrationAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * RegistrationKeyMakerUseCase constructor.
     * @param RegistrationKeyMakerRequestValidatorInterface $validator
     * @param RegistrationKeyMakerResponseAssemblerInterface $responseAssembler
     * @param KeyMakerAdditionInterface $keyMakerAddition
     * @param RegistrationAdditionInterface $registrationAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        RegistrationKeyMakerRequestValidatorInterface $validator,
        RegistrationKeyMakerResponseAssemblerInterface $responseAssembler,
        KeyMakerAdditionInterface $keyMakerAddition,
        RegistrationAdditionInterface $registrationAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->responseAssembler = $responseAssembler;
        $this->keyMakerAddition = $keyMakerAddition;
        $this->registrationAddition = $registrationAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param RegistrationKeyMakerRequest $request
     * @return RegistrationKeyMakerResponse
     */
    public function execute(RegistrationKeyMakerRequest $request): RegistrationKeyMakerResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        $registrationId = RegistrationId::createFrom($request->getRegistrationId());
        $this->registrationAddition->repositoryContainsIdOrNotFound($registrationId);

        /** @var RegistrationKeyMaker|null $keyMaker */
        $keyMaker = $this->keyMakerAddition->findKeyMakerOfRegistrationOrNotFound(
            $registrationId,
            'Registration data not found.',
        );

        return $this->responseAssembler->assemble($keyMaker);
    }
}
