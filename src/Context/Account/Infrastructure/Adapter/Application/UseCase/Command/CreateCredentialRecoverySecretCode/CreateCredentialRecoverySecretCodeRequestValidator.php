<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode\{
    CreateCredentialRecoverySecretCodeRequest,
    CreateCredentialRecoverySecretCodeRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateCredentialRecoverySecretCodeRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
final class CreateCredentialRecoverySecretCodeRequestValidator extends AbstractRequestValidator implements
    CreateCredentialRecoverySecretCodeRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * CreateCredentialRecoverySecretCodeRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param CreateCredentialRecoverySecretCodeRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(CreateCredentialRecoverySecretCodeRequest $request): ErrorListInterface
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
