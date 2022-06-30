<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserByCredential;

use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\Query\UserByCredential\{
    UserByCredentialRequest,
    UserByCredentialRequestValidatorInterface,
};
use App\Context\Account\Infrastructure\Adapter\Application\UseCase\AbstractRequestValidator;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound;
use App\Context\Account\Infrastructure\Validation\Constraint\Compound\AbstractCompound;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserByCredentialRequestValidator
 * @package App\Context\Account\Infrastructure\Adapter\Application\UseCase\Query\UserByCredential
 */
final class UserByCredentialRequestValidator extends AbstractRequestValidator implements
    UserByCredentialRequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * UserByCredentialRequestValidator constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        parent::__construct($serializer);
        $this->validator = $validator;
    }

    /**
     * @param UserByCredentialRequest $request
     * @return ErrorListInterface
     * @throws Exception
     */
    public function validate(UserByCredentialRequest $request): ErrorListInterface
    {
        $input = $this->requestToArray($request);

        $constraint = new Assert\Collection(
            [
                'fields' => [
                    'login' => new Assert\Required(
                        [
                            new Assert\NotNull(),
                            new Assert\Type('string'),
                            new Assert\Length(['min' => 5]),
                        ],
                    ),
                    'password' => new Assert\Required(
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
