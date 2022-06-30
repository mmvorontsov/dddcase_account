<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\UpdateUserCredentialPassword;

use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword\{
    UpdateUserCredentialPasswordRequest,
    UpdateUserCredentialPasswordRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdateUserCredentialPasswordRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Command\UpdateUserCredentialPassword
 */
final class UpdateUserCredentialPasswordRequestValidator extends AbstractRequestValidator implements
    UpdateUserCredentialPasswordRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * UpdateUserCredentialPasswordRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param UpdateUserCredentialPasswordRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(UpdateUserCredentialPasswordRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'userId' => new Assert\Required([new Compound\UuidCompound()]),
                    'password' => new Assert\Required(
                        [
                            new Compound\PasswordCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
                        ],
                    ),
                    'currentPassword' => new Assert\Required(
                        [
                            new Compound\PasswordCompound(['payload' => [AbstractCompound::NOT_NULL => []]]),
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
