<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker\{
    CredentialRecoveryKeyMakerRequest,
    CredentialRecoveryKeyMakerRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CredentialRecoveryKeyMakerRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
final class CredentialRecoveryKeyMakerRequestValidator extends AbstractRequestValidator implements
    CredentialRecoveryKeyMakerRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * CredentialRecoveryKeyMakerRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param CredentialRecoveryKeyMakerRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(CredentialRecoveryKeyMakerRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'credentialRecoveryId' => new Assert\Required(
                        [
                            new Compound\UuidCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                        ],
                    ),
                ],
                'allowMissingFields' => false,
                'allowExtraFields' => false,
            ]
        );

        return $this->getErrorList(
            $this->validator->validate($input, $constraint),
        );
    }
}
