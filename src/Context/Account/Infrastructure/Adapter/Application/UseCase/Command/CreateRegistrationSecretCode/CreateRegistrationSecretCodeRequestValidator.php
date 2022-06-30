<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode\{
    CreateRegistrationSecretCodeRequest,
    CreateRegistrationSecretCodeRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateRegistrationSecretCodeRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateRegistrationSecretCode
 */
final class CreateRegistrationSecretCodeRequestValidator extends AbstractRequestValidator implements
    CreateRegistrationSecretCodeRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * CreateRegistrationSecretCodeRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param CreateRegistrationSecretCodeRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(CreateRegistrationSecretCodeRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'registrationId' => new Assert\Required(
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
