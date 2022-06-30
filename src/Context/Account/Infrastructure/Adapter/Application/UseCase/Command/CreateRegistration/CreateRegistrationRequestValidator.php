<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\CreateRegistration\{
    CreateRegistrationRequest,
    CreateRegistrationRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateRegistrationRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\CreateRegistration
 */
final class CreateRegistrationRequestValidator extends AbstractRequestValidator implements
    CreateRegistrationRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * CreateRegistrationRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param CreateRegistrationRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(CreateRegistrationRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'firstname' => new Assert\Required(
                        [
                            new Compound\FirstnameCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                        ],
                    ),
                    'password' => new Assert\Required(
                        [
                            new Compound\PasswordCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                        ],
                    ),
                    'email' => new Assert\Required(
                        [
                            new Compound\EmailCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
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
