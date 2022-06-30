<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Application\UseCase\Addition\KeyMakerAdditionInterface;
use App\Context\Account\Application\UseCase\Addition\ValidatorAdditionInterface;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\CredentialRecoveryKeyMaker;

/**
 * Class CredentialRecoveryKeyMakerUseCase
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
final class CredentialRecoveryKeyMakerUseCase implements CredentialRecoveryKeyMakerUseCaseInterface
{
    /**
     * @var CredentialRecoveryKeyMakerRequestValidatorInterface
     */
    private CredentialRecoveryKeyMakerRequestValidatorInterface $validator;

    /**
     * @var CredentialRecoveryKeyMakerResponseAssemblerInterface
     */
    private CredentialRecoveryKeyMakerResponseAssemblerInterface $responseAssembler;

    /**
     * @var KeyMakerAdditionInterface
     */
    private KeyMakerAdditionInterface $keyMakerAddition;

    /**
     * @var ValidatorAdditionInterface
     */
    private ValidatorAdditionInterface $validatorAddition;

    /**
     * CredentialRecoveryKeyMakerUseCase constructor.
     * @param CredentialRecoveryKeyMakerRequestValidatorInterface $validator
     * @param CredentialRecoveryKeyMakerResponseAssemblerInterface $responseAssembler
     * @param KeyMakerAdditionInterface $keyMakerAddition
     * @param ValidatorAdditionInterface $validatorAddition
     */
    public function __construct(
        CredentialRecoveryKeyMakerRequestValidatorInterface $validator,
        CredentialRecoveryKeyMakerResponseAssemblerInterface $responseAssembler,
        KeyMakerAdditionInterface $keyMakerAddition,
        ValidatorAdditionInterface $validatorAddition,
    ) {
        $this->validator = $validator;
        $this->responseAssembler = $responseAssembler;
        $this->keyMakerAddition = $keyMakerAddition;
        $this->validatorAddition = $validatorAddition;
    }

    /**
     * @param CredentialRecoveryKeyMakerRequest $request
     * @return CredentialRecoveryKeyMakerResponse
     */
    public function execute(CredentialRecoveryKeyMakerRequest $request): CredentialRecoveryKeyMakerResponse
    {
        $this->validatorAddition->isEmptyErrorListOrUnprocessableEntity($this->validator->validate($request));

        /** @var CredentialRecoveryKeyMaker|null $keyMaker */
        $keyMaker = $this->keyMakerAddition->findKeyMakerOfCredentialRecoveryOrNotFound(
            CredentialRecoveryId::createFrom($request->getCredentialRecoveryId()),
            'Credential recovery data not found.',
        );

        return $this->responseAssembler->assemble($keyMaker);
    }
}
