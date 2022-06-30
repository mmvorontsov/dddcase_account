<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationRequest;
use App\Context\Account\Application\UseCase\Command\SignRegistration\SignRegistrationRequestValidatorInterface;
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SignRegistrationRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\SignRegistration
 */
final class SignRegistrationRequestValidator extends AbstractRequestValidator implements
    SignRegistrationRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * SignRegistrationRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param SignRegistrationRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(SignRegistrationRequest $request): ErrorListInterface
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
                    'secretCode' => new Assert\Required(
                        [
                            new Compound\SecretCodeCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
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
